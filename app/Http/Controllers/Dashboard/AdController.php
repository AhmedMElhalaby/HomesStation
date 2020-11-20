<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BookingAds;
use App\Models\Device;
use App\Http\Controllers\General\NotificationController;

class AdController extends Controller
{
    public function waiting_ads()
    {
        $this->data['ads'] = BookingAds::where(['acceptable' => 'waiting'])->get();
        return view('dashboard.ads.waiting', $this->data);
    }

    public function accepted_ads()
    {
        $this->data['ads'] = BookingAds::where(['acceptable' => 'accepted'])->get();
        return view('dashboard.ads.accepted', $this->data);
    }

    public function unaccepted_ads()
    {
        $this->data['ads'] = BookingAds::where(['acceptable' => 'unaccepted'])->get();
        return view('dashboard.ads.unaccepted', $this->data);
    }

    public function reply_ad_request(Request $request)
    {
        if (!BookingAds::find($request->ads_id)) {
            $response = ['status' => 'false', 'message' => trans('dash.try_2_access_not_found_content')];
            return $response;
        }
        $booking_ads = BookingAds::find($request->ads_id);
        if ($request->reply == 'accept') {
            $booking_ads->update(['acceptable' => 'accepted']);

            $body = 'قامت الإدارة بالموافقة على عرض الإعلان الخاص بك';
            $title_ar = 'قامت إدارة تطبيق هوم استشين بإرسال إشعار';
            $title_en = 'home station management has sent notice to you';
            $title = app()->getLocale() == 'ar' ? $title_ar : $title_en;

            $fcm_data = [];
            $fcm_data['title'] = $title;
            $fcm_data['key'] = 'adv_accepted';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = $request->user()->username;
            $fcm_data['sender_logo'] = asset('storage/app/uploads/default.png');
            $fcm_data['time'] = date('Y-m-d H:i:s');

            add_notification($booking_ads->user_id, 'management_message', 0, $body, $body);

            if (Device::where('user_id', $booking_ads->user_id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($booking_ads->user_id, $title, $body, $fcm_data, (60 * 20));
            }
        } else {
            $booking_ads->update(['acceptable' => 'unaccepted']);

            $body = 'قامت الإدارة برفض طلبك لعرض الإعلان الخاص بك';
            $title_ar = 'قامت إدارة تطبيق هوم استشين بإرسال إشعار';
            $title_en = 'home station management has sent notice to you';
            $title = app()->getLocale() == 'ar' ? $title_ar : $title_en;

            $fcm_data = [];
            $fcm_data['title'] = $title;
            $fcm_data['key'] = 'adv_rejected';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = $request->user()->username;
            $fcm_data['sender_logo'] = asset('storage/app/uploads/default.png');
            $fcm_data['time'] = date('Y-m-d H:i:s');

            add_notification($booking_ads->user_id, 'management_message', 0, $body, $body);

            if (Device::where('user_id', $booking_ads->user_id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($booking_ads->user_id, $title, $request->message, $fcm_data, (60 * 20));
            }
            $booking_ads->forceDelete();
        }
        return ['status' => 'true', 'message' => trans('dash.sent_successfully')];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!BookingAds::find($id)) {
            $response = ['status' => 'false', 'message' => trans('dash.try_2_access_not_found_content')];
            return $response;
        }
        $book_ads = BookingAds::find($id)->forceDelete();
        return ['status' => 'true', 'message' => trans('dash.deleted_successfully')];
    }
}
