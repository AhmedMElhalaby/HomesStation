<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Device;
use App\Http\Resources\OrderDetails;
use App\User;
use App\Http\Resources\MiniProviderOrder;
use App\Http\Controllers\General\NotificationController;

class ProviderOrderController extends MasterController
{

    /** 
     * new orders for provider api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function new_orders(Request $request)
    {
        if (!User::where('type', 'provider')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($request->user()->id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        try {
            return response()->json([
                'status' => 'true',
                'message' => '',
                'data' => MiniProviderOrder::collection(Order::where('provider_id', $provider->id)
                    ->whereIn(
                        'order_status',
                        [
                            'products_client_waiting',
                            'services_client_waiting',
                        ]
                    )->orderBy('created_at', 'DESC')->get())
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
    }

    /** 
     * current orders for provider api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function current_orders(Request $request)
    {
        if (!User::where('type', 'provider')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($request->user()->id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        try {
            return response()->json([
                'status' => 'true',
                'message' => '',
                'data' => MiniProviderOrder::collection(Order::where('provider_id', $provider->id)
                    ->whereNotIn(
                        'order_status',
                        [
                            'products_client_waiting',
                            'services_client_waiting',
                            'products_provider_rejected',
                            'services_provider_rejected',
                            'products_finished_order_without_rate',
                            'services_finished_order_without_rate',
                            'products_finished_order_with_rate',
                            'services_finished_order_with_rate'
                        ]
                    )
                    ->orderBy('created_at', 'DESC')->get())
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
    }

    /** 
     * current orders for provider api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function finished_orders(Request $request)
    {
        if (!User::where('type', 'provider')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($request->user()->id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        try {
            return response()->json([
                'status' => 'true',
                'message' => '',
                'data' => MiniProviderOrder::collection(Order::where('provider_id', $provider->id)
                    ->whereIn(
                        'order_status',
                        [
                            'products_provider_rejected',
                            'services_provider_rejected',
                            'products_finished_order_without_rate',
                            'services_finished_order_without_rate',
                            'products_finished_order_with_rate',
                            'services_finished_order_with_rate'
                        ]
                    )->orderBy('created_at', 'DESC')->get())
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
        if (!User::where('type', 'provider')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($request->user()->id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($order_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.order_id_required'), 'data' => null], 401);
        if (!Order::where(['id' => $order_id, 'provider_id' => $provider->id])->first())
            return response()->json(['status' => 'false', 'message' => trans('app.order_not_found'), 'data' => null], 404);
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
     * accept order by provider api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function accept_order(Request $request, $order_id = null)
    {
        if (!User::where('type', 'provider')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($request->user()->id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($order_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.order_id_required'), 'data' => null], 401);
        if (!Order::find($order_id))
            return response()->json(['status' => 'false', 'message' => trans('app.order_not_found'), 'data' => null], 404);
        if (!Order::whereIn('order_status', ['products_client_waiting', 'services_client_waiting'])->find($order_id))
            return response()->json(['status' => 'false', 'message' => trans('app.can_not_accept_or_reject_this_order'), 'data' => null], 505);
        try {
            $order = Order::find($order_id);
            if ($order->order_category_type == 'products') {
                if (!$request->has_delegate)
                    return response()->json(['status' => 'false', 'message' => trans('app.has_delegate_required'), 'data' => null], 401);
                if ($request->has_delegate == 'no') {
                    $order->update([
                        'order_status' => 'products_provider_accepted_and_search_about_delegate',
                        'delivery_price' => (double)settings('delivery_price'),
                        'has_provider_delegate' => "no",
                    ]);
                } else {
                    $order->update([
                        'order_status' => 'products_provider_accepted_and_provider_will_be_delivered_the_order',
                        'delivery_price' => (double)settings('delivery_price'),
                        'has_provider_delegate' => "yes",
                    ]);
                }
            } else {
                $order->update(['order_status' => 'services_provider_accepted']);
            }

            // =========================== Notification ===========================
            $title = trans('app.fcm.title');

            $fcm_data = [];
            $fcm_data['title'] = $title;

            $body_ar = 'قام ' . $request->user()->username . ' بالموافقة على الطلب رقم ' . $order->id;
            $body_en = $request->user()->username . ' has accepted order No. ' . $order->id;
            $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

            $fcm_data['key'] = 'accept_order';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = $request->user()->username;
            $fcm_data['sender_logo'] = $request->user()->profile_image;
            $fcm_data['order_id'] = $order->id;
            $fcm_data['time'] = $order->updated_at->diffforhumans();

            add_notification($order->user_id, 'order', $order->id, $body_ar, $body_en);
            if (Device::where('user_id', $order->user_id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->user_id, $title, $body, $fcm_data, (60 * 20));
            }
            if ($order->has_provider_delegate == 'no') {
                $delegates = User::where(['type' => 'delegate'])->active()->subscribed()->get();
                foreach ($delegates as $delegate) {
                    $fcm_data = [];
                    $fcm_data['title'] = $title;

                    $body_ar = 'طلب جديد';
                    $body_en = 'new order';
                    $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

                    $fcm_data['key'] = 'new_order';
                    $fcm_data['body'] = $body;
                    $fcm_data['msg_sender'] = $request->user()->username;
                    $fcm_data['sender_logo'] = $request->user()->profile_image;
                    $fcm_data['order_id'] = $order->id;
                    $fcm_data['time'] = $order->updated_at->diffforhumans();

                    if (Device::where('user_id', $delegate->id)->exists()) {
                        NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($delegate->id, $title, $body, $fcm_data, (60 * 20));
                    }
                }
            }
            // =========================== Notification ===========================

            return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => new OrderDetails(Order::find($order_id))], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
    }

    /** 
     * accept order by provider api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function reject_order(Request $request, $order_id = null)
    {
        if (!User::where('type', 'provider')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($request->user()->id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($order_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.order_id_required'), 'data' => null], 401);
        if (!Order::where(['id' => $order_id, 'provider_id' => $provider->id])->first())
            return response()->json(['status' => 'false', 'message' => trans('app.order_not_found'), 'data' => null], 404);
        if (!Order::whereIn('order_status', ['products_client_waiting', 'services_client_waiting'])->find($order_id))
            return response()->json(['status' => 'false', 'message' => trans('app.can_not_accept_or_reject_this_order'), 'data' => null], 505);
        try {
            $order = Order::find($order_id);
            if ($order->order_category_type == 'products') {
                $order->update(['order_status' => 'products_provider_rejected']);
            } else {
                $order->update(['order_status' => 'services_provider_rejected']);
            }

            // =========================== Notification ===========================
            $title = trans('app.fcm.title');

            $fcm_data = [];
            $fcm_data['title'] = $title;

            $body_ar = 'قام ' . $request->user()->username . ' برفض الطلب رقم ' . $order->id;
            $body_en = $request->user()->username . ' has rejected order No. ' . $order->id;
            $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

            $fcm_data['key'] = 'reject_order';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = $request->user()->username;
            $fcm_data['sender_logo'] = $request->user()->profile_image;
            $fcm_data['order_id'] = $order->id;
            $fcm_data['time'] = $order->updated_at->diffforhumans();

            add_notification($order->user_id, 'order', $order->id, $body_ar, $body_en);

            if (Device::where('user_id', $order->user_id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->user_id, $title, $body, $fcm_data, (60 * 20));
            }
            // =========================== Notification ===========================

            return response()->json([
                'status' => 'true',
                'message' => trans('app.sent_successfully'),
                'data' => new OrderDetails(Order::find($order_id)),
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
    }

    /** 
     * accept order by provider api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function successfully_processed(Request $request, $order_id = null)
    {
        if (!User::where('type', 'provider')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($request->user()->id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($order_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.order_id_required'), 'data' => null], 401);
        if (!Order::where(['id' => $order_id, 'provider_id' => $provider->id])->first())
            return response()->json(['status' => 'false', 'message' => trans('app.order_not_found'), 'data' => null], 404);
        try {
            $order = Order::find($order_id);
            if ($order->order_category_type == 'products') {
                if ($order->has_provider_delegate == 'yes') {
                    $body_ar = 'قام ' . $request->user()->username . ' بالإنتهاء من الطلب رقم ' . $order->id . ' وجاري توصيل الطلب.';
                    $body_en = $request->user()->username . ' finished order No. ' . $order->id . ' and it\'s on the way.';
                    $order->update(['order_status' => 'products_delegate_on_the_way']);
                } else {
                    if ($order->delegate_id == null) {
                        $body_ar = 'قام ' . $request->user()->username . ' بالإنتهاء من الطلب رقم ' . $order->id . 'في انتظار المندوب للموافقة على توصيل الطلب';
                        $body_en = $request->user()->username . ' finished order No. ' . $order->id . ' and Waiting for the delegate to accept the order';
                        $order->update(['order_status' => 'products_order_processed_delegate_waiting_to_accept']);
                    } else {
                        $body_ar = 'قام ' . $request->user()->username . ' بالإنتهاء من الطلب رقم ' . $order->id . 'في انتظار المندوب';
                        $body_en = $request->user()->username . ' finished order No. ' . $order->id . ' and Waiting for the delegate';
                        $order->update(['order_status' => 'products_order_processed_delegate_waiting_to_receive']);
                    }
                }
            } else {
                $body_ar = 'مندوب الخدمه في الطريق';
                $body_en = 'the provider on the way';
                $order->update(['order_status' => 'services_delegate_on_the_way']);
            }

            // =========================== Notification ===========================
            $title = trans('app.fcm.title');

            $fcm_data = [];
            $fcm_data['title'] = $title;

            $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

            $fcm_data['key'] = 'finished_processing_order';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = $request->user()->username;
            $fcm_data['sender_logo'] = $request->user()->profile_image;
            $fcm_data['order_id'] = $order->id;
            $fcm_data['time'] = $order->updated_at->diffforhumans();

            add_notification($order->user_id, 'order', $order->id, $body_ar, $body_en);

            if (Device::where('user_id', $order->user_id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->user_id, $title, $body, $fcm_data, (60 * 20));
            }

            if ($order->delegate_id != null) {
                add_notification($order->delegate_id, 'order', $order->id, $body_ar, $body_en);

                if (Device::where('user_id', $order->delegate_id)->exists()) {
                    NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->delegate_id, $title, $body, $fcm_data, (60 * 20));
                }
            }
            // =========================== Notification ===========================

            return response()->json([
                'status' => 'true',
                'message' => trans('app.sent_successfully'),
                'data' => new OrderDetails(Order::find($order_id)),
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
    }

    /** 
     * accept order by provider api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function delivered_order_to_delegate(Request $request, $order_id = null)
    {
        if (!User::where('type', 'provider')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($request->user()->id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($order_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.order_id_required'), 'data' => null], 401);
        if (!Order::where(['id' => $order_id, 'provider_id' => $provider->id])->first())
            return response()->json(['status' => 'false', 'message' => trans('app.order_not_found'), 'data' => null], 404);
        $order = Order::find($order_id);
        if ($order->order_category_type == 'services' || $order->has_provider_delegate == 'yes' || $order->delegate_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.can_not_modify_status_for_this_order'), 'data' => null], 404);
        try {
            $order->update(['order_status' => 'products_delegate_on_the_way']);
            // =========================== Notification ===========================
            $title = trans('app.fcm.title');

            $fcm_data = [];
            $fcm_data['title'] = $title;

            $body_ar = 'قام ' . $request->user()->username . ' بتسليم الطلب رقم ' . $order->id . ' إلى المندوب ' . $order->Delegate->username . ' وجاري التوصيل';
            $body_en = $request->user()->username . ' delivered order No. ' . $order->id . ' to delegate '. $order->Delegate->username .' and it\'s on the way.';
            $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

            $fcm_data['key'] = 'provider_delivered_order_to_delegate';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = $request->user()->username;
            $fcm_data['sender_logo'] = $request->user()->profile_image;
            $fcm_data['order_id'] = $order->id;
            $fcm_data['time'] = $order->updated_at->diffforhumans();

            add_notification($order->user_id, 'order', $order->id, $body_ar, $body_en);
            if (Device::where('user_id', $order->user_id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->user_id, $title, $body, $fcm_data, (60 * 20));
            }

            if ($order->delegate_id != null) {
                add_notification($order->delegate_id, 'order', $order->id, $body_ar, $body_en);

                if (Device::where('user_id', $order->delegate_id)->exists()) {
                    NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->delegate_id, $title, $body, $fcm_data, (60 * 20));
                }
            }
            // =========================== Notification ===========================
            return response()->json([
                'status' => 'true',
                'message' => trans('app.sent_successfully'),
                'data' => new OrderDetails(Order::find($order_id)),
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
    }

    /** 
     * accept order by provider api 
     * 
     * @return \Illuminate\Http\Response 
     */
    public function finish_order(Request $request, $order_id = null)
    {
        if (!User::where('type', 'provider')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.provider_not_found'), 'data' => null], 404);
        $provider = User::where('type', 'provider')->find($request->user()->id);
        if ($provider->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($provider->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($order_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.order_id_required'), 'data' => null], 401);
        if (!Order::where(['id' => $order_id, 'provider_id' => $provider->id])->first())
            return response()->json(['status' => 'false', 'message' => trans('app.order_not_found'), 'data' => null], 404);
        $order = Order::find($order_id);
        if ($order->order_category_type == 'products' && ($order->has_provider_delegate == 'no' || $order->delegate_id != null))
            return response()->json(['status' => 'false', 'message' => trans('app.can_not_modify_status_for_this_order'), 'data' => null], 404);
        try {
            if ($order->order_category_type == 'products') {
                $order->update(['order_status' => 'products_finished_order_without_rate']);
            } else {
                $order->update(['order_status' => 'services_finished_order_without_rate']);
            }

            // =========================== Notification ===========================
            $title = trans('app.fcm.title');

            $fcm_data = [];
            $fcm_data['title'] = $title;

            $body_ar = 'قام ' . $request->user()->username . ' بتسليم الطلب رقم ' . $order->id;
            $body_en = $request->user()->username . ' has delivered order No. ' . $order->id;
            $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

            $fcm_data['key'] = 'provider_finish_order';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = $request->user()->username;
            $fcm_data['sender_logo'] = $request->user()->profile_image;
            $fcm_data['order_id'] = $order->id;
            $fcm_data['time'] = $order->updated_at->diffforhumans();

            add_notification($order->user_id, 'order', $order->id, $body_ar, $body_en);
            if (Device::where('user_id', $order->user_id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->user_id, $title, $body, $fcm_data, (60 * 20));
            }
            
            // =========================== Notification ===========================

            return response()->json([
                'status' => 'true',
                'message' => trans('app.sent_successfully'),
                'data' => new OrderDetails(Order::find($order_id)),
            ], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
    }
}
