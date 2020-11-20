<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\Models\Device;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\Provider as ProviderResource;
use App\Http\Requests\Api\Auth\RegisterProviderRequest;
use App\Models\Provider;
use abdullahobaid\mobilywslaraval\Mobily;
use App\Http\Requests\Api\Provider\UpdateProviderDataRequest;
use App\Http\Requests\Api\Provider\UpdateProviderPasswordRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\CategoryProvider as CategoryProviderResource;
use App\Http\Resources\MiniProductResource;
use App\Http\Resources\ProviderProfileResource;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\Api\Provider\UpdateStoreDataRequest;
use App\Http\Resources\MiniServiceResource;
use App\Http\Resources\ProviderRate as ProviderRateResource;
use App\Models\UserReport;
use App\Http\Controllers\General\NotificationController;
use App\Models\SubcategoryTag;
use App\Http\Resources\SubcategoryTag as SubcategoryTagResource;
use App\Models\Subcategory;
use App\Http\Resources\Subcategory as SubcategoryResource;
use App\Models\Category;
use App\Http\Controllers\General\SmsController;

class ProviderController extends MasterController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
        if ($request->header('Authorization')) {
            $this->middleware('jwt.auth');
        }
    }
    
    public function login()
    {
        if (Auth::attempt(['mobile' => filter_mobile_number(request('mobile')), 'password' => request('password'), 'type' => 'provider'])) {
            $provider = Auth::user();
            if ($provider->active != 'active')
                return response()->json(['status' => 'false', 'message' => trans('auth.deactivation_message'), 'data' => ['token_type' => 'Bearer', 'access_token' => JWTAuth::fromUser($provider)]], 403);
            if ($provider->banned != '0')
                return response()->json(['status' => 'false', 'message' => trans('auth.banned_message'), 'data' => null], 401);
            if (request('device_id') && request('device_type')) {
                $device = Device::updateOrCreate(['user_id' => $provider->id, 'device_type' => request('device_type')], ['device_id' => request('device_id')]);
            }
            return response(['status' => 'true', 'message' => trans('auth.success_login'), 'data' => new ProviderResource($provider)], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('auth.failed_login'), 'data' => null], 401);
        }
    }

    /** 
     * Register api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function register(RegisterProviderRequest $request)
    {
        DB::beginTransaction();
        try {
            $provider = User::create($request->validated() + ['role_id' => 1, 'active' => 'deactive', 'type' => 'provider', 'code' => generate_code()]);
            $provider_data = Provider::create($request->validated() + ['user_id' => $provider->id]);
            $cat_arr = json_decode($request->categories);
            $provider->Categories()->attach(array_column($cat_arr, 'id'));
            if (request('device_id') && request('device_type')) {
                $device = Device::updateOrCreate(['user_id' => $provider->id, 'device_type' => request('device_type')], ['device_id' => request('device_id')]);
            }
            
            $code_message = 'كود%20التفعيل%20:%20' . $provider->code;
            (new SmsController())->send_sms($provider->mobile, $code_message);
            
            if (settings('free_trial_availability') == 'available') {
                $expire_date = calc_expire_date(settings('free_trial_period_type'), settings('free_trial_period'));
                $provider->update([
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
                $fcm_data['msg_sender'] = $provider->username;
                $fcm_data['sender_logo'] = asset('storage/app/uploads/default.png');
                $fcm_data['time'] = date('Y-m-d H:i:s');

                add_notification($provider->id, 'management_message', 0, $body_ar, $body_en);

                if (Device::where('user_id', $provider->id)->exists()) {
                    NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($provider->id, $title, $body, $fcm_data, (60 * 20));
                }
            }
            DB::commit();
            $token = JWTAuth::fromUser($provider);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
        return response()->json(['status' => 'true', 'message' => trans('auth.success_register'), 'data' => ['token_type' => 'Bearer', 'access_token' => $token], 'code' => $provider->code], 200);
    }

    /** 
     * show user data api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function show(Request $request, $provider_id = null)
    {
        if ($provider_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.provider_id_required'), 'data' => null], 422);
        if (!User::where('type', 'provider')->find($provider_id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($provider_id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        $provider->ProviderData->update(['views_count' => ($provider->ProviderData->views_count + 1)]);
        return response(['status' => 'true', 'message' => '', 'data' => new ProviderProfileResource(User::where('type', 'provider')->active()->find($provider_id))], 200);
    }

    public function update(UpdateProviderDataRequest $request)
    {
        DB::beginTransaction();
        try {
            $provider = User::find($request->user()->id);
            $provider->update($request->validated());
            $provider->ProviderData->update($request->validated());
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
        return response(['status' => 'true', 'message' => trans('app.updated_successfully'), 'data' => new ProviderResource(User::active()->find($request->user()->id))], 200);
    }

    public function update_store_data(UpdateStoreDataRequest $request)
    {
        DB::beginTransaction();
        try {
            $provider = User::find($request->user()->id);
            $provider_data = $request->validated();
            unset($provider_data['categories']);
            Provider::where('user_id', $request->user()->id)->update($provider_data);
            if ($request->categories) {
                $cat_arr = json_decode($request->categories);
                $provider->Categories()->sync(array_column($cat_arr, 'id'));
            }
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
        return response(['status' => 'true', 'message' => trans('app.updated_successfully'), 'data' => new ProviderResource(User::active()->find($request->user()->id))], 200);
    }

    public function update_password(UpdateProviderPasswordRequest $request)
    {
        if (Hash::check($request->old_password, $request->user()->password)) {
            $provider = User::find($request->user()->id);
            $provider->update(['password' => $request->password]);
            return response(['status' => 'true', 'message' => trans('app.updated_successfully'), 'data' => new ProviderResource(User::active()->find($request->user()->id))], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('app.password_not_match'), 'data' => null], 401);
        }
    }

    public function active(Request $request)
    {
        if (!$request->code)
            return response()->json(['status' => 'false', 'message' => trans('app.code_required'), 'data' => null], 422);
        $provider = User::where(['code' => $request->code])->find($request->user()->id);
        if ($provider) {
            $provider->update(['code' => '', 'active' => 'active']);
            if (request('device_id') && request('device_type')) {
                $device = Device::updateOrCreate(['user_id' => $provider->id, 'device_type' => request('device_type')], ['device_id' => request('device_id')]);
            }
            return response(['status' => 'true', 'message' => trans('app.activated_successfully'), 'data' => new ProviderResource(User::active()->find($request->user()->id))], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('app.wrong_code'), 'data' => null], 401);
        }
    }

    public function forgot_password(Request $request)
    {
        if (!$request->mobile)
            return response()->json(['status' => 'false', 'message' => trans('app.mobile_required'), 'data' => null], 422);
        $mobile = filter_mobile_number($request->mobile);
        $provider = User::where(['mobile' => $mobile, 'type' => 'provider'])->first();
        if ($provider) {
            $provider->update(['code' => generate_code()]);
            
            $code_message = 'كود%20التفعيل%20:%20' . $provider->code;
            (new SmsController())->send_sms($provider->mobile, $code_message);
            
            return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => ['token_type' => 'Bearer', 'access_token' => JWTAuth::fromUser($provider)], 'code' => $provider->code], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 401);
        }
    }

    public function confirm_code(Request $request)
    {
        if (!$request->code)
            return response()->json(['status' => 'false', 'message' => trans('app.code_required'), 'data' => null], 422);

        $mobile = filter_mobile_number($request->user()->mobile);
        $provider = User::where(['mobile' => $mobile, 'code' => $request->code, 'type' => 'provider'])->first();
        if ($provider) {
            $provider->update(['code' => '', 'active' => 'active']);            
            return response()->json(['status' => 'true', 'message' => '', 'data' => ['token_type' => 'Bearer', 'access_token' => JWTAuth::fromUser($provider)]], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('app.wrong_code'), 'data' => null], 401);
        }
    }

    public function change_password(Request $request)
    {
        if (!$request->new_password)
            return response()->json(['status' => 'false', 'message' => trans('app.new_password_required'), 'data' => null], 422);

        $provider = User::where('type', 'provider')->find($request->user()->id);
        if ($provider) {
            if ($provider->banned != '0')
                return response()->json(['status' => 'false', 'message' => trans('auth.banned_message'), 'data' => null], 401);
            $provider->update(['password' => $request->new_password]);
            if (request('device_id') && request('device_type')) {
                $device = Device::updateOrCreate(['user_id' => $provider->id, 'device_type' => request('device_type')], ['device_id' => request('device_id')]);
            }
            return response(['status' => 'true', 'message' => trans('app.updated_successfully'), 'data' => new ProviderResource(User::active()->find($request->user()->id))], 200);
        } else {
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 401);
        }
    }

    public function logout(Request $request)
    {
        if (!$request->device_type)
            return response()->json(['status' => 'false', 'message' => trans('app.device_type_required'), 'data' => null], 422);

        Device::where(['user_id' => $request->user()->id, 'device_type' => $request->device_type])->delete();
        return response()->json(['status' => 'true', 'message' => trans('auth.success_logout'), 'data' => null], 200);
    }

    public function get_categories($provider_id = null)
    {
        if ($provider_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.provider_id_required'), 'data' => null], 422);
        if (!User::where('type', 'provider')->find($provider_id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($provider_id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        $provider = User::find($provider_id);
        return response(['status' => 'true', 'message' => '', 'data' => CategoryProviderResource::collection($provider->CategoriesProvider)], 200);
    }

    public function my_services(Request $request, $provider_id = null)
    {
        if ($provider_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.provider_id_required'), 'data' => null], 422);
        if (!User::where('type', 'provider')->find($provider_id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($provider_id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        
        if($request->subcategory_tag_id){
            $services = $provider->Services()->where('subcategory_tag_id', $request->subcategory_tag_id)->get();
        }else{
            $services = $provider->Services;
        }

        return response(['status' => 'true', 'message' => '', 'data' => MiniServiceResource::collection($services)], 200);
    }

    public function get_rates(Request $request, $provider_id = null)
    {
        if ($provider_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.provider_id_required'), 'data' => null], 422);
        if (!User::where('type', 'provider')->find($provider_id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($provider_id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        return response(['status' => 'true', 'message' => '', 'data' => ProviderRateResource::collection($provider->ProviderRates)], 200);
    }

    public function statistics(Request $request)
    {
        if (!User::where('type', 'provider')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($request->user()->id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        $data['product_count'] = $provider->Services->count();
        $data['visits_count'] = $provider->ProviderData->views_count;
        $data['order_count'] = $provider->ProviderOrders->count();
        $data['rate_count'] = $provider->ProviderRates->count();
        return response(['status' => 'true', 'message' => '', 'data' => $data], 200);
    }

    public function send_report(Request $request, $provider_id = null)
    {        
        if ($request->reason == null)
            return response()->json(['status' => 'false', 'message' => trans('app.reason_required'), 'data' => null], 401);
        if ($provider_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.provider_id_required'), 'data' => null], 422);
        if (!User::where('type', 'provider')->find($provider_id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($provider_id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        $report = UserReport::create([
            'user_id' => $request->user()->id,
            'key' => 'provider',
            'key_id' => $provider_id,
            'reason' => $request->reason,
        ]);
        return response(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => null], 200);
    }

    public function my_tags($provider_id = null, $subcategory_id = null)
    {
        if ($subcategory_id == null) {
            return response()->json(['status' => 'false', 'message' => trans('app.subcategory_id_required'), 'data' => null], 422);
        }
        if (!Subcategory::find($subcategory_id)) {
            return response()->json(['status' => 'false', 'message' => trans('app.category_not_found'), 'data' => null], 404);
        }
        if ($provider_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.provider_id_required'), 'data' => null], 422);
        if (!User::where('type', 'provider')->find($provider_id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($provider_id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        $provider_tags = SubcategoryTag::where('subcategory_id', $subcategory_id)->whereHas('Services', function($query) use ($provider_id){
            $query->where('provider_id', $provider_id);
        })->get();
        return response(['status' => 'true', 'message' => '', 'data' => SubcategoryTagResource::collection($provider_tags)], 200);
    }
    
    public function my_subcategories($provider_id = null, $category_id = null)
    {
        if ($category_id == null) {
            return response()->json(['status' => 'false', 'message' => trans('app.category_id_required'), 'data' => null], 422);
        }
        if (!Category::find($category_id)) {
            return response()->json(['status' => 'false', 'message' => trans('app.category_not_found'), 'data' => null], 404);
        }
        if ($provider_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.provider_id_required'), 'data' => null], 422);
        if (!User::where('type', 'provider')->find($provider_id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($provider_id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        $provider_subcategories = Subcategory::where('category_id', $category_id)->whereHas('Services', function ($query) use ($provider_id) {
            $query->where('provider_id', $provider_id);
        })->get();
        return response(['status' => 'true', 'message' => '', 'data' => SubcategoryResource::collection($provider_subcategories)], 200);
    }

}
