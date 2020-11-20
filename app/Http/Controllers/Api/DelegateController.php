<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Device;
use Auth;
use JWTAuth;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\Api\Auth\RegisterDelegateRequest;
use App\Http\Resources\Auth\Delegate as DelegateAuthResource;
use App\Http\Resources\Delegate as DelegateProfileResource;
use App\Http\Requests\Api\Delegate\UpdateDelegateDataRequest;
use App\Http\Requests\Api\Delegate\UpdateDelegatePasswordRequest;
use App\Http\Controllers\General\NotificationController;
use App\Http\Controllers\General\SmsController;

class DelegateController extends MasterController
{
    public function login()
    {
        if (JWTAuth::attempt(['mobile' => filter_mobile_number(request('mobile')), 'password' => request('password'), 'type' => 'delegate'])) {
            $delegate = Auth::user();
            if ($delegate->active != 'active')
                return response()->json(['status' => 'false', 'message' => trans('auth.deactivation_message'), 'data' => ['token' => $delegate->token]], 403);
            if ($delegate->banned != '0')
                return response()->json(['status' => 'false', 'message' => trans('auth.banned_message'), 'data' => null], 401);
            if (request('device_id') && request('device_type')) {
                $device = Device::updateOrCreate(['user_id' => $delegate->id, 'device_type' => request('device_type')], ['device_id' => request('device_id')]);
            }
            return response(['status' => 'true', 'message' => trans('auth.success_login'), 'data' => new DelegateAuthResource($delegate)], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('auth.failed_login'), 'data' => null], 401);
        }
    }

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function register(RegisterDelegateRequest $request)
    {
        $delegate = User::create($request->validated() + ['role_id' => 1, 'active' => 'deactive', 'type' => 'delegate', 'code' => generate_code()]);
        if (request('device_id') && request('device_type')) {
            $device = Device::updateOrCreate(['user_id' => $delegate->id, 'device_type' => request('device_type')], ['device_id' => request('device_id')]);
        }
        
        $code_message = 'كود%20التفعيل%20:%20' . $delegate->code;
        (new SmsController())->send_sms($delegate->mobile, $code_message);
        
        if (settings('free_trial_availability') == 'available') {
            $expire_date = calc_expire_date(settings('free_trial_period_type'), settings('free_trial_period'));
            $delegate->update([
                'expire_date' => $expire_date,
            ]);

            $title_ar = 'قامت إدارة تطبيق هوم استشين بإرسال إشعار';
            $title_en = 'home station management has sent notice to you';
            $title = app()->getLocale() == 'ar' ? $title_ar : $title_en;

            $body_ar = 'مرحبا بك في تطبيق هوم استيشن انت الان في فترة تجربه مجانيه حتى تاريخ ' . $expire_date;
            $body_en = 'Welcome to the application of Home Station you are now in a free trial to date ' . $expire_date;
            $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

            $fcm_data = [];
            $fcm_data['title'] = $title;
            $fcm_data['key'] = 'management_message';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = $delegate->username;
            $fcm_data['sender_logo'] = asset('storage/app/uploads/default.png');
            $fcm_data['time'] = date('Y-m-d H:i:s');

            add_notification($delegate->id, 'management_message', 0, $body_ar, $body_en);

            if (Device::where('user_id', $delegate->id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($delegate->id, $title, $body, $fcm_data, (60 * 20));
            }
        }
        $token = JWTAuth::fromUser($delegate);
        return response()->json(['status' => 'true', 'message' => trans('auth.success_register'), 'data' => ['token_type' => 'Bearer', 'access_token' => $token], 'code' => $delegate->code], 200);
    }

    public function active(Request $request)
    {
        if (!$request->code)
            return response()->json(['status' => 'false', 'message' => trans('app.code_required'), 'data' => null], 422);
        $delegate = User::where(['code' => $request->code])->find($request->user()->id);
        if ($delegate) {
            $delegate = User::find($request->user()->id);
            $delegate->update(['code' => '', 'active' => 'active']);
            if (request('device_id') && request('device_type')) {
                $device = Device::updateOrCreate(['user_id' => $delegate->id, 'device_type' => request('device_type')], ['device_id' => request('device_id')]);
            }
            return response(['status' => 'true', 'message' => trans('app.activated_successfully'), 'data' => new DelegateAuthResource($delegate)], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('app.wrong_code'), 'data' => null], 401);
        }
    }

    public function forgot_password(Request $request)
    {
        if (!$request->mobile)
            return response()->json(['status' => 'false', 'message' => trans('app.mobile_required'), 'data' => null], 422);
        $mobile = filter_mobile_number($request->mobile);
        $delegate = User::where(['mobile' => $mobile, 'type' => 'delegate'])->first();
        if ($delegate) {
            $delegate->update(['code' => generate_code()]);
            
        $code_message = 'كود%20التفعيل%20:%20' . $delegate->code;
        (new SmsController())->send_sms($delegate->mobile, $code_message);
            
            return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => ['token_type' => 'Bearer', 'access_token' => JWTAuth::fromUser($delegate)], 'code' => $delegate->code], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 401);
        }
    }

    public function confirm_code(Request $request)
    {
        if (!$request->code)
            return response()->json(['status' => 'false', 'message' => trans('app.code_required'), 'data' => null], 422);

        $mobile = filter_mobile_number($request->user()->mobile);
        $delegate = User::where(['mobile' => $mobile, 'code' => $request->code, 'type' => 'delegate'])->first();
        if ($delegate) {
            $delegate->update(['code' => '', 'active' => 'active']);
            return response()->json(['status' => 'true', 'message' => '', 'data' => ['token_type' => 'Bearer', 'access_token' => JWTAuth::fromUser($delegate)]], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('app.wrong_code'), 'data' => null], 401);
        }
    }

    public function change_password(Request $request)
    {
        if (!$request->new_password)
            return response()->json(['status' => 'false', 'message' => trans('app.new_password_required'), 'data' => null], 422);

        $delegate = User::where('type', 'delegate')->find($request->user()->id);
        if ($delegate) {
            if ($delegate->banned != '0')
                return response()->json(['status' => 'false', 'message' => trans('auth.banned_message'), 'data' => null], 401);
            $delegate->update(['password' => $request->new_password]);
            if (request('device_id') && request('device_type')) {
                $device = Device::firstOrNew(['user_id' => $delegate->id, 'device_type' => request('device_type')]);
                $device->device_id = request('device_id');
                $device->save();
            }
            return response(['status' => 'true', 'message' => trans('app.updated_successfully'), 'data' => new DelegateAuthResource($delegate)], 200);
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

    /** 
     * show user data api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function show(Request $request, $delegate_id = null)
    {
        if ($delegate_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.delegate_id_required'), 'data' => null], 422);
        if (!User::where('type', 'delegate')->find($delegate_id))
            return response()->json(['status' => 'false', 'message' => trans('app.delegate_not_found'), 'data' => null], 404);
        $delegate = User::where('type', 'delegate')->find($delegate_id);
        if ($delegate->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($delegate->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        return response(['status' => 'true', 'message' => '', 'data' => new DelegateProfileResource($delegate)], 200);
    }

    public function update(UpdateDelegateDataRequest $request)
    {
        $delegate = User::find($request->user()->id);
        $delegate->update($request->validated());
        return response(['status' => 'true', 'message' => trans('app.updated_successfully'), 'data' => new DelegateAuthResource($delegate)], 200);
    }

    public function update_password(UpdateDelegatePasswordRequest $request)
    {
        if (Hash::check($request->old_password, $request->user()->password)) {
            $user = User::find($request->user()->id);
            $user->update(['password' => $request->password]);
            return response(['status' => 'true', 'message' => trans('app.updated_successfully'), 'data' => new DelegateAuthResource(User::active()->find($request->user()->id))], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('app.password_not_match'), 'data' => null], 401);
        }
    }
}
