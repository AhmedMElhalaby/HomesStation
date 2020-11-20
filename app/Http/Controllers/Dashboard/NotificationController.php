<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Http\Requests\Dashboard\Notification\SendSingle;
use App\Http\Controllers\General\NotificationController as SendNotificationController;
use App\Http\Requests\Dashboard\Notification\SendMultiple;
use App\User;

class NotificationController extends Controller
{
    public function send_single_notification(SendSingle $request)
    {
        $title_ar = 'قامت إدارة تطبيق هومز استشين بإرسال إشعار';
        $title_en = 'homes station management has sent notice to you';
        $title = app()->getLocale() == 'ar' ? $title_ar : $title_en;
        
        $fcm_data = [];
        $fcm_data['title'] = $title;
        $fcm_data['key'] = 'management_message';
        $fcm_data['body'] = $request->message;
        $fcm_data['msg_sender'] = $request->user()->username;
        $fcm_data['sender_logo'] = asset('storage/app/uploads/default.png');
        $fcm_data['time'] = date('Y-m-d H:i:s');

        add_notification($request->user_id, 'management_message', 0, $request->message, $request->message);

        if (Device::where('user_id', $request->user_id)->exists()) {
            SendNotificationController::SEND_SINGLE_STATIC_NOTIFICATION($request->user_id, $title, $request->message, $fcm_data, (60 * 20));
        }
        return back()->with('class', 'alert alert-success')->with('message', trans('dash.sent_successfully'));
    }

    public function send_multiple_notification(SendMultiple $request)
    {
        $users = User::where('type', $request->type)->get();
        foreach ($users as $user) {
            $title_ar = 'قامت إدارة تطبيق هومز استشين بإرسال إشعار';
            $title_en = 'homes station management has sent notice to you';
            $title = app()->getLocale() == 'ar' ? $title_ar : $title_en;

            $fcm_data = [];
            $fcm_data['title'] = $title;
            $fcm_data['key'] = 'management_message';
            $fcm_data['body'] = $request->message;
            $fcm_data['msg_sender'] = auth()->user()->username;
            $fcm_data['sender_logo'] = asset('storage/app/uploads/default.png');
            $fcm_data['time'] = date('Y-m-d H:i:s');

            add_notification($user->id, 'management_message', 0, $request->message, $request->message);

            if (Device::where('user_id', $user->id)->exists()) {
                SendNotificationController::SEND_SINGLE_STATIC_NOTIFICATION($user->id, $title, $request->message, $fcm_data, (60 * 20));
            }
        }        
        return back()->with('class', 'alert alert-success')->with('message', trans('dash.sent_successfully'));
    }
}
