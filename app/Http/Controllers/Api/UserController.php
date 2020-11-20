<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Hash;
use abdullahobaid\mobilywslaraval\Mobily;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\Api\User\UpdateUserDataRequest;
use App\Http\Requests\Api\User\UpdateUserPasswordRequest;
use App\Http\Requests\Api\Auth\RegisterUserRequest;
use App\Models\UserSocial;
use App\Http\Requests\Api\Auth\SocialLogin;
use App\Http\Controllers\General\SmsController;


class UserController extends MasterController
{
    public function login_with_social(SocialLogin $request)
    {
        if (UserSocial::where(['social_type' => $request->social_type, 'social_id' => $request->social_id])->first()) {
            $user_social = UserSocial::where(['social_type' => $request->social_type, 'social_id' => $request->social_id])->first();
            $user = User::find($user_social->user_id);
            if ($user->active != 'active')
                return response()->json(['status' => 'false', 'message' => trans('auth.deactivation_message'), 'data' => ['token' => $user->token]], 403);
            if ($user->banned != '0')
                return response()->json(['status' => 'false', 'message' => trans('auth.banned_message'), 'data' => null], 401);
            if (request('device_id') && request('device_type')) {
                $device = Device::updateOrCreate(['user_id' => $user->id, 'device_type' => request('device_type')], ['device_id' => request('device_id')]);
            }
            return response(['status' => 'true', 'message' => trans('auth.success_login'), 'data' => new UserResource($user)], 200);
        } else {
            if(User::where('email', $request->email)->first()){
                $user = User::where('email', $request->email)->first();
                if ($user->active != 'active')
                    return response()->json(['status' => 'false', 'message' => trans('auth.deactivation_message'), 'data' => ['token' => $user->token]], 403);
                if ($user->banned != '0')
                    return response()->json(['status' => 'false', 'message' => trans('auth.banned_message'), 'data' => null], 401);
                if (request('device_id') && request('device_type')) {
                    $device = Device::updateOrCreate(['user_id' => $user->id, 'device_type' => request('device_type')], ['device_id' => request('device_id')]);
                }
                UserSocial::create($request->validated() + ['user_id' => $user->id]);
                return response(['status' => 'true', 'message' => trans('auth.success_login'), 'data' => new UserResource($user)], 200);
            }
            return response()->json(['status' => 'false', 'message' => trans('auth.failed_login'), 'data' => null], 401);
        }
    }

    public function login()
    {
        if (JWTAuth::attempt(['mobile' => filter_mobile_number(request('mobile')), 'password' => request('password'), 'type' => 'user'])) {
            $user = Auth::user();
            if ($user->active != 'active')
                return response()->json(['status' => 'false', 'message' => trans('auth.deactivation_message'), 'data' => ['token' => $user->token]], 403);
            if ($user->banned != '0')
                return response()->json(['status' => 'false', 'message' => trans('auth.banned_message'), 'data' => null], 401);
            if (request('device_id') && request('device_type')) {
                $device = Device::updateOrCreate(['user_id' => $user->id, 'device_type' => request('device_type')], ['device_id' => request('device_id')]);
            }
            return response(['status' => 'true', 'message' => trans('auth.success_login'), 'data' => new UserResource($user)], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('auth.failed_login'), 'data' => null], 401);
        }
    }

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function register(RegisterUserRequest $request)
    {
        $user = User::create($request->validated() + ['role_id' => 1, 'active' => 'deactive', 'type' => 'user', 'code' => generate_code()]);        
        if (request('device_id') && request('device_type')) {
            $device = Device::updateOrCreate(['user_id' => $user->id, 'device_type' => request('device_type')], ['device_id' => request('device_id')]);
        }
        if (request('social_type') && request('social_id')) {
            UserSocial::create(['user_id' => $user->id, 'social_type' => request('social_type'), 'social_id' => request('social_id')]);
        }
        
        $code_message = 'كود%20التفعيل%20:%20' . $user->code;
        (new SmsController())->send_sms($user->mobile, $code_message);
        
        $token = JWTAuth::fromUser($user);
        return response()->json(['status' => 'true', 'message' => trans('auth.success_register'), 'data' => ['token_type' => 'Bearer', 'access_token' => $token], 'code' => $user->code], 200);
    }

    /** 
     * show user data api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function show(Request $request, $user_id = null)
    {
        if ($user_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.user_id_required'), 'data' => null], 422);
        if (!User::where('type', 'user')->find($user_id))
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 404);
        $user = User::where('type', 'user')->find($user_id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        return response(['status' => 'true', 'message' => '', 'data' => new UserResource(User::where('type', 'user')->active()->find($user_id))], 200);
    }

    public function update(UpdateUserDataRequest $request)
    {
        $user = User::find($request->user()->id);
        $user->update($request->validated());
        return response(['status' => 'true', 'message' => trans('app.updated_successfully'), 'data' => new UserResource(User::active()->find($request->user()->id))], 200);
    }

    public function update_password(UpdateUserPasswordRequest $request)
    {
        if (Hash::check($request->old_password, $request->user()->password)) {
            $user = User::find($request->user()->id);
            $user->update(['password' => $request->password]);
            return response(['status' => 'true', 'message' => trans('app.updated_successfully'), 'data' => new UserResource(User::active()->find($request->user()->id))], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('app.password_not_match'), 'data' => null], 401);
        }
    }

    public function active(Request $request)
    {
        if (!$request->code)
            return response()->json(['status' => 'false', 'message' => trans('app.code_required'), 'data' => null], 422);
        $user = User::where(['code' => $request->code])->find($request->user()->id);
        if ($user) {
            $user = User::find($request->user()->id);
            $user->update(['code' => '', 'active' => 'active']);
            if (request('device_id') && request('device_type')) {
                $device = Device::updateOrCreate(['user_id' => $user->id, 'device_type' => request('device_type')], ['device_id' => request('device_id')]);
            }
            return response(['status' => 'true', 'message' => trans('app.activated_successfully'), 'data' => new UserResource(User::active()->find($request->user()->id))], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('app.wrong_code'), 'data' => null], 401);
        }
    }

    public function forgot_password(Request $request)
    {
        if (!$request->mobile)
            return response()->json(['status' => 'false', 'message' => trans('app.mobile_required'), 'data' => null], 422);
        $mobile = filter_mobile_number($request->mobile);
        $user = User::where(['mobile' => $mobile, 'type' => 'user'])->first();
        if ($user) {
            $user->update(['code' => generate_code()]);
            
            $code_message = 'كود%20التفعيل%20:%20' . $user->code;
            (new SmsController())->send_sms($user->mobile, $code_message);
            
            return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => ['token_type' => 'Bearer', 'access_token' => JWTAuth::fromUser($user)], 'code' => $user->code], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 401);
        }
    }

    public function confirm_code(Request $request)
    {
        if (!$request->code)
            return response()->json(['status' => 'false', 'message' => trans('app.code_required'), 'data' => null], 422);

        $mobile = filter_mobile_number($request->user()->mobile);
        $user = User::where(['mobile' => $mobile, 'code' => $request->code, 'type' => 'user'])->first();
        if ($user) {
            $user->update(['code' => '', 'active' => 'active']);            
            return response()->json(['status' => 'true', 'message' => '', 'data' => ['token_type' => 'Bearer', 'access_token' => JWTAuth::fromUser($user)]], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('app.wrong_code'), 'data' => null], 401);
        }
    }

    public function change_password(Request $request)
    {
        if (!$request->new_password)
            return response()->json(['status' => 'false', 'message' => trans('app.new_password_required'), 'data' => null], 422);

        $user = User::where('type', 'user')->find($request->user()->id);
        if ($user) {
            if ($user->banned != '0')
                return response()->json(['status' => 'false', 'message' => trans('auth.banned_message'), 'data' => null], 401);
            $user->update(['password' => $request->new_password]);
            if (request('device_id') && request('device_type')) {
                $device = Device::updateOrCreate(['user_id' => $user->id, 'device_type' => request('device_type')], ['device_id' => request('device_id')]);
            }
            return response(['status' => 'true', 'message' => trans('app.updated_successfully'), 'data' => new UserResource(User::active()->find($request->user()->id))], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 401);
        }
    }

    public function logout(Request $request)
    {
        if (!$request->device_type)
            return response()->json(['status' => 'false', 'message' => trans('app.device_type_required'), 'data' => null], 422);

        Device::where(['user_id' => $request->user()->id, 'device_type' => $request->device_type])->delete();
        return response()->json(['status' => 'true', 'message' => trans('auth.success_logout'), 'data' => null], 200);
    }

    public function getAuthenticatedUser()
    {
        try {

            if (!$user = JWTAuth::parseToken()->authenticate()) {
                return response()->json(['user_not_found'], 404);
            }

        } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            return response()->json(['token_expired'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            return response()->json(['token_invalid'], $e->getStatusCode());

        } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {

            return response()->json(['token_absent'], $e->getStatusCode());

        }

        return response()->json(compact('user'));
    }
}
