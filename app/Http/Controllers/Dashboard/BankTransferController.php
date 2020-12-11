<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BankTransfer;
use App\Models\Subscription;
use App\User;
use App\Models\Device;
use App\Http\Controllers\General\NotificationController;

class BankTransferController extends Controller
{
    public function pay_advertising_fees()
    {
        $this->data['bank_transfers'] = BankTransfer::where('type', 'pay_advertising_fees')->get();
        return view('dashboard.bank_transfers.ads', $this->data);
    }

    public function pay_of_the_delegate_subscription()
    {
        $this->data['bank_transfers'] = BankTransfer::where('type', 'pay_of_the_delegate_subscription')->get();
        return view('dashboard.bank_transfers.delegate', $this->data);
    }

    public function pay_of_the_provider_subscription()
    {
        $this->data['bank_transfers'] = BankTransfer::where('type', 'pay_of_the_provider_subscription')->get();
        return view('dashboard.bank_transfers.providers_subscriptions', $this->data);
    }

    public function retrieve_bank_transfer(Request $request)
    {
        if (!BankTransfer::find($request->bank_transfer_id)) {
            $response = ['status' => 'false', 'message' => trans('dash.try_2_access_not_found_content')];
            return $response;
        }
        $bank_transfer = BankTransfer::find($request->bank_transfer_id);
        if ($request->reply == 'accept') {

            // pay_of_the_provider_subscription - pay_advertising_fees - pay_of_the_delegate_subscription

            if ($bank_transfer->type == 'pay_advertising_fees') {
                $bank_transfer->forceDelete();
                $response = ['status' => 'true', 'message' => trans('dash.transfer_was_successful')];
                return $response;
            } elseif ($bank_transfer->type == 'pay_of_the_provider_subscription') {
                $user = User::find($bank_transfer->user_id);
                $subscription = Subscription::find($bank_transfer->type_id);
                $expire_date = calc_expire_date($subscription->period_type, $subscription->period);
                $user->update(['expire_date' => $expire_date,'expiration_notification'=>false]);
                $bank_transfer->forceDelete();

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

                $response = ['status' => 'true', 'message' => trans('dash.transfer_was_successful')];
                return $response;
            } elseif ($bank_transfer->type == 'pay_of_the_delegate_subscription') {
                $user = User::find($bank_transfer->user_id);
                $subscription = Subscription::find($bank_transfer->type_id);
                $expire_date = calc_expire_date($subscription->period_type, $subscription->period);
                $user->update(['expire_date' => $expire_date]);
                $bank_transfer->forceDelete();

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

                $response = ['status' => 'true', 'message' => trans('dash.transfer_was_successful')];
                return $response;
            } else {
                $response = ['status' => 'false', 'message' => trans('dash.try_2_access_not_found_content')];
                return $response;
            }
            $bank_transfer->forceDelete();
        } else {
            $bank_transfer->forceDelete();
            $response = ['status' => 'true', 'message' => trans('dash.transfer_declined')];
            return $response;
        }
    }
}
