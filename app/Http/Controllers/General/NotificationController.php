<?php

namespace App\Http\Controllers\General;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Device;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;

class NotificationController extends Controller
{
    // public static function SEND_SINGLE_STATIC_NOTIFICATION($user_id, $notification_title, $notification_body, $notification_data, $time_to_live)
    // {
    //     $tokens = Device::where('user_id', $user_id)->pluck('device_id')->toArray();
    //     // dd($tokens);
    //     // dd($tokens);
    //     // $tokens = 'csBPwqU2U03dnWv-DtZzkL:APA91bHgc12qCXdCXTA-v2Nn8xu8YCgs73TsnOBdZBgb8ZmdVzQo-VZpKA7dRkYQWW1JQpVxxoE2maaCaF-RFuFyD1cwh2_dj7hjE_Zj15IDMXf3k984hXPX-HQVRyYJ9jyJ-wghF';
    //     $optionBuilder = new OptionsBuilder();
    //     $optionBuilder->setTimeToLive($time_to_live);
    //     $notificationBuilder = new PayloadNotificationBuilder($notification_title);
    //     $notificationBuilder->setBody($notification_body)->setSound('default');
    //     $dataBuilder = new PayloadDataBuilder();
    //     $dataBuilder->addData($notification_data);
    //     $option = $optionBuilder->build();
    //     $notification = $notificationBuilder->build();
           
    //     $data = $dataBuilder->build();
    //     $downstreamResponse = FCM::sendTo($tokens, $option, $notification, $data);
        
    //     // dd($downstreamResponse->tokensToDelete()+$downstreamResponse->tokensWithError());
        
    //     Device::whereIn('device_id', $downstreamResponse->tokensToDelete()+$downstreamResponse->tokensWithError())->delete();

    //     // dd($downstreamResponse);
    // }
    
    public static function SEND_SINGLE_STATIC_NOTIFICATION($user_id, $notification_title, $notification_body, $notification_data, $time_to_live)
    {
        $user_devices = Device::where('user_id', $user_id)->get();
        foreach ($user_devices as $user_device) {
            try{
                // dd($user_device);
                $optionBuilder = new OptionsBuilder();
                $optionBuilder->setTimeToLive($time_to_live);
                $notificationBuilder = new PayloadNotificationBuilder($notification_title);
                $notificationBuilder->setBody($notification_body)->setSound('default');
                $dataBuilder = new PayloadDataBuilder();
                $dataBuilder->addData($notification_data);
                $option = $optionBuilder->build();
                if ($user_device->device_type == 'ios') {
                    $notification = $notificationBuilder->build();
                } else {
                    $notification = null;
                }
                $data = $dataBuilder->build();
                $downstreamResponse = FCM::sendTo($user_device->device_id, $option, $notification, $data);
            } catch (Exception $e) {
                dd($e);
                return response()->json(['status' => 'false', 'message' => trans('app.messages.something_went_wrong_please_try_again'), 'data' => null], 401);
            }
            // dd($downstreamResponse = FCM::sendTo($user_device->device_id, $option, $notification, $data));
        }
    }
}
