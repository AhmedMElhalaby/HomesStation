<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MiniDelegateOrder;
use App\User;
use App\Models\Order;
use App\Models\Device;
use App\Http\Resources\OrderDetails;
use App\Http\Controllers\General\NotificationController;

class DelegateOrderController extends MasterController
{
    /** 
     * new orders for delegate api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function new_orders(Request $request)
    {
        if (!User::where('type', 'delegate')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.delegate_not_found'), 'data' => null], 404);
        $delegate = User::where('type', 'delegate')->find($request->user()->id);
        if ($delegate->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($delegate->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        try {
            return response()->json([
                'status' => 'true',
                'message' => '',
                'data' => MiniDelegateOrder::collection(Order::where(['delegate_id' => null, 'has_provider_delegate' => 'no', 'order_category_type' => 'products'])->orderBy('created_at', 'DESC')->get())
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
    }

    /** 
     * current orders for delegate api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function current_orders(Request $request)
    {
        if (!User::where('type', 'delegate')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.delegate_not_found'), 'data' => null], 404);
        $delegate = User::where('type', 'delegate')->find($request->user()->id);
        if ($delegate->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($delegate->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        try {
            return response()->json([
                'status' => 'true',
                'message' => '',
                'data' => MiniDelegateOrder::collection(Order::where('delegate_id', $delegate->id)->orderBy('created_at', 'DESC')->get())
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
    }

    /** 
     * order details for provider api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function details(Request $request, $order_id = null)
    {
        if (!User::where('type', 'delegate')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.delegate_not_found'), 'data' => null], 404);
        $delegate = User::where('type', 'delegate')->find($request->user()->id);
        if ($delegate->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($delegate->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($order_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.order_id_required'), 'data' => null], 401);
        try {
            return response()->json([
                'status' => 'true',
                'message' => '',
                'data' => new OrderDetails(Order::find($order_id)),
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
    }

    /** 
     * accept order by delegate api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function accept_order(Request $request, $order_id = null)
    {
        if (!User::where('type', 'delegate')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.delegate_not_found'), 'data' => null], 404);
        $delegate = User::where('type', 'delegate')->find($request->user()->id);
        if ($delegate->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($delegate->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($order_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.order_id_required'), 'data' => null], 401);
        if (!Order::find($order_id))
            return response()->json(['status' => 'false', 'message' => trans('app.order_not_found'), 'data' => null], 404);
        if (!Order::where(['delegate_id' => null, 'has_provider_delegate' => 'no', 'order_category_type' => 'products'])->first())
            return response()->json(['status' => 'false', 'message' => trans('app.can_not_accept_or_reject_this_order'), 'data' => null], 505);
        try {
            $order = Order::find($order_id);
            if ($order->order_status == 'products_provider_accepted_and_search_about_delegate') {
                $order->update(['order_status' => 'products_delegate_accepted_order_being_processed', 'delegate_id' => $delegate->id]);
            } elseif ($order->order_status == 'products_order_processed_delegate_waiting_to_accept') {
                $order->update(['order_status' => 'products_order_processed_delegate_waiting_to_receive', 'delegate_id' => $delegate->id]);
            } else {
                return response()->json(['status' => 'false', 'message' => trans('app.can_not_accept_or_reject_this_order'), 'data' => null], 401);
            }

            // =========================== Notification ===========================
            $title = trans('app.fcm.title');

            $fcm_data = [];
            $fcm_data['title'] = $title;

            $body_ar = 'قام ' . $request->user()->username . ' بالموافقة على الطلب رقم ' . $order->id;
            $body_en = $request->user()->username . ' has accepted order No. ' . $order->id;
            $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

            $fcm_data['key'] = 'delegate_accept_order';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = $request->user()->username;
            $fcm_data['sender_logo'] = $request->user()->profile_image;
            $fcm_data['order_id'] = $order->id;
            $fcm_data['time'] = $order->updated_at->diffforhumans();

            add_notification($order->provider_id, 'order', $order->id, $body_ar, $body_en);
            if (Device::where('user_id', $order->provider_id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->provider_id, $title, $body, $fcm_data, (60 * 20));
            }

            add_notification($order->user_id, 'order', $order->id, $body_ar, $body_en);
            if (Device::where('user_id', $order->user_id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->user_id, $title, $body, $fcm_data, (60 * 20));
            }
            
            // =========================== Notification ===========================

            
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
        return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => new OrderDetails($order)], 200);
    }

    /** 
     * receive order by delegate api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function receive_order(Request $request, $order_id = null)
    {
        if (!User::where('type', 'delegate')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.delegate_not_found'), 'data' => null], 404);
        $delegate = User::where('type', 'delegate')->find($request->user()->id);
        if ($delegate->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($delegate->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($order_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.order_id_required'), 'data' => null], 401);
        if (!Order::find($order_id))
            return response()->json(['status' => 'false', 'message' => trans('app.order_not_found'), 'data' => null], 404);
        if (!Order::where('delegate_id', $delegate->id)->where(['order_status' => 'order_processed_delegate_waiting_to_receive'])->find($order_id))
            return response()->json(['status' => 'false', 'message' => trans('app.can_not_accept_or_reject_this_order'), 'data' => null], 505);
        try {
            $order = Order::find($order_id);
            $order->update(['order_status' => 'products_delegate_on_the_way']);

            // =========================== Notification ===========================
            $title = trans('app.fcm.title');

            $fcm_data = [];
            $fcm_data['title'] = $title;

            $body_ar = 'قام ' . $request->user()->username . ' باستلام الطلب رقم ' . $order->id;
            $body_en = $request->user()->username . ' has received order No. ' . $order->id;
            $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

            $fcm_data['key'] = 'delegate_receive_order';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = $request->user()->username;
            $fcm_data['sender_logo'] = $request->user()->profile_image;
            $fcm_data['order_id'] = $order->id;
            $fcm_data['time'] = $order->updated_at->diffforhumans();

            add_notification($order->provider_id, 'order', $order->id, $body_ar, $body_en);
            if (Device::where('user_id', $order->provider_id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->provider_id, $title, $body, $fcm_data, (60 * 20));
            }

            add_notification($order->user_id, 'order', $order->id, $body_ar, $body_en);
            if (Device::where('user_id', $order->user_id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->user_id, $title, $body, $fcm_data, (60 * 20));
            }
            
            // =========================== Notification ===========================

            return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => new OrderDetails(Order::find($order_id))], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
    }

    /** 
     * finish order by delegate api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function finish_order(Request $request, $order_id = null)
    {
        if (!User::where('type', 'delegate')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.delegate_not_found'), 'data' => null], 404);
        $delegate = User::where('type', 'delegate')->find($request->user()->id);
        if ($delegate->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($delegate->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($order_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.order_id_required'), 'data' => null], 401);
        if (!Order::find($order_id))
            return response()->json(['status' => 'false', 'message' => trans('app.order_not_found'), 'data' => null], 404);
        if (!Order::where(['delegate_id' => $delegate->id, 'order_status' => 'products_delegate_on_the_way'])->find($order_id))
            return response()->json(['status' => 'false', 'message' => trans('app.can_not_accept_or_reject_this_order'), 'data' => null], 505);
        try {
            $order = Order::find($order_id);
            $order->update(['order_status' => 'products_finished_order_without_rate']);

            // =========================== Notification ===========================
            $title = trans('app.fcm.title');

            $fcm_data = [];
            $fcm_data['title'] = $title;

            $body_ar = 'قام ' . $request->user()->username . ' بتسليم الطلب رقم ' . $order->id;
            $body_en = $request->user()->username . ' has delivered order No. ' . $order->id;
            $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

            $fcm_data['key'] = 'delegate_finish_order';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = $request->user()->username;
            $fcm_data['sender_logo'] = $request->user()->profile_image;
            $fcm_data['order_id'] = $order->id;
            $fcm_data['time'] = $order->updated_at->diffforhumans();

            add_notification($order->provider_id, 'order', $order->id, $body_ar, $body_en);
            if (Device::where('user_id', $order->provider_id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->provider_id, $title, $body, $fcm_data, (60 * 20));
            }

            add_notification($order->user_id, 'order', $order->id, $body_ar, $body_en);
            if (Device::where('user_id', $order->user_id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->user_id, $title, $body, $fcm_data, (60 * 20));
            }
            
            // =========================== Notification ===========================

            return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => new OrderDetails(Order::find($order_id))], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
    }
}
