<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\General\NotificationController;
use App\Models\Device;
use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\BankTransfer\StoreRequest;
use App\Http\Requests\Api\BankTransfer\TransactionStoreRequest;
use App\Models\BankTransfer;
use App\User;

class BankTransferController extends MasterController
{
    public function send(StoreRequest $request)
    {
        if (!User::find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 404);
        $user = User::find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        $bank_transfer = BankTransfer::create($request->validated() + ['user_id' => $request->user()->id]);
        return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => null], 200);
    }

    public function send_transaction(TransactionStoreRequest $request)
    {
        if (!User::find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 404);
        $user = User::find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        $transaction = \App\Models\Transactions::create($request->validated() + ['user_id' => $request->user()->id]);
        if ($request->type == 'pay_of_the_provider_subscription'){
            $user = User::find($request->user()->id);
            $subscription = Subscription::find($request->type_id);
            $expire_date = calc_expire_date($subscription->period_type, $subscription->period);
            $user->update(['expire_date' => $expire_date,'expiration_notification'=>false]);

            $title_ar = 'قامت إدارة تطبيق هوم استشين بإرسال إشعار';
            $title_en = 'home station management has sent notice to you';
            $title = app()->getLocale() == 'ar' ? $title_ar : $title_en;

            $body_ar = 'مرحبا بك في تطبيق هوم استيشن تم تفعيل الاشتراك الخاص بك حتى تاريخ ' . $expire_date;
            $body_en = 'Welcome to Home Station. Your subscription has been activated up to date ' . $expire_date;
            $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

            $fcm_data = [];
            $fcm_data['title'] = $title;
            $fcm_data['key'] = 'management_message';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = $user->username;
            $fcm_data['sender_logo'] = asset('storage/app/uploads/default.png');
            $fcm_data['time'] = date('Y-m-d H:i:s');

            add_notification($user->id, 'management_message', 0, $body_ar, $body_en);

            if (Device::where('user_id', $user->id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($user->id, $title, $body, $fcm_data, (60 * 20));
            }
        }elseif($request->type == 'pay_of_the_delegate_subscription'){
            $user = User::find($request->user()->id);
            $subscription = Subscription::find($request->type_id);
            $expire_date = calc_expire_date($subscription->period_type, $subscription->period);
            $user->update(['expire_date' => $expire_date]);

            $title_ar = 'قامت إدارة تطبيق هوم استشين بإرسال إشعار';
            $title_en = 'home station management has sent notice to you';
            $title = app()->getLocale() == 'ar' ? $title_ar : $title_en;

            $body_ar = 'مرحبا بك في تطبيق هوم استيشن تم تفعيل الاشتراك الخاص بك حتى تاريخ ' . $expire_date;
            $body_en = 'Welcome to Home Station. Your subscription has been activated up to date ' . $expire_date;
            $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

            $fcm_data = [];
            $fcm_data['title'] = $title;
            $fcm_data['key'] = 'management_message';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = $user->username;
            $fcm_data['sender_logo'] = asset('storage/app/uploads/default.png');
            $fcm_data['time'] = date('Y-m-d H:i:s');

            add_notification($user->id, 'management_message', 0, $body_ar, $body_en);

            if (Device::where('user_id', $user->id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($user->id, $title, $body, $fcm_data, (60 * 20));
            }
        }
        return response()->json(['status' => 'true', 'message' => trans('app.subscription_renewed_successfully'), 'data' => null], 200);
    }
}
