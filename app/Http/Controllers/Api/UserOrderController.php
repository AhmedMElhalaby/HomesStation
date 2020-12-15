<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\AdditionOrderService;
use App\Models\Cart;
use App\Models\Service;
use App\Models\BookingOrder;
use App\Http\Resources\MiniUserOrder;
use App\Http\Resources\OrderDetails;
use App\Models\ProviderRate;
use App\Models\Provider;
use App\Models\Device;
use App\Http\Controllers\General\NotificationController;

class UserOrderController extends MasterController
{
    /**
     * create new order by user api
     *
     * @return \Illuminate\Http\Response
     */
    public function create_from_cart(Request $request)
    {
        if (!$request->lat || !$request->lng)
            return response()->json(['status' => 'false', 'message' => trans('app.lat_and_lng_required'), 'data' => null], 422);
        if (!User::where('type', 'user')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 404);
        $user = User::where('type', 'user')->find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if (count($user->Cart) <= 0)
            return response()->json(['status' => 'false', 'message' => trans('app.cart_is_empty'), 'data' => null], 401);
        DB::beginTransaction();
        try {
            $carts = $user->Cart;
            $provider = User::find($carts[0]->provider_id);
            $order = Order::create([
                'user_id' => $user->id,
                'provider_id' => $provider->id,
                'delivery_price' => 0,
                'order_status' => 'products_client_waiting',
                'app_precentage_from_provider' => settings('app_precentage_from_provider'),
                'lat' => $request->lat,
                'lng' => $request->lng,
                'details' => @$request->details,
                'is_deliverable'=>$carts[0]->is_deliverable
            ]);
            $total_order_price = 0;
            foreach ($carts as $cart) {
                $total_service_price = 0;
                $total_service_price = cart_block_price($cart->id);
                $total_order_price += $total_service_price;
                $order_service = OrderService::create([
                    'order_id' => $order->id,
                    'service_id' => $cart->service_id,
                    'count' => $cart->count,
                    'service_price' => $cart->Service->has_offer == 'yes' ? ($cart->Service->price - ($cart->Service->price * $cart->Service->offer_price) / 100) : $cart->Service->price,
                    'total_price' => $total_service_price
                ]);

                // $order_service = BookingOrder::create([
                //     'order_id' => $order->id,
                //     'service_id' => $cart->service_id,
                //     'service_price' => $cart->Service->price
                // ]);
                $order->update(['category_id' => $cart->Service->category_id, 'order_category_type' => $cart->Service->Category->type]);
                foreach ($cart->AdditionCart as $addition_cart) {
                    $total_addition_price = 0;
                    $total_addition_price = $addition_cart->count * $addition_cart->Addition->price;
                    $total_order_price += $total_addition_price;
                    // $order_service->AdditionOrderService()->sync([
                    //     18 => [
                    //         'count' => $addition_cart->count,
                    //         'addition_service_price' => $addition_cart->Addition->price,
                    //         'total_price' => $total_addition_price,
                    //     ],
                    //     // 'order_service_id' => $order_service->id,
                    //     // 'addition_service_id' => $addition_cart->addition_id,
                    // ]);
                    $addition_order_service = AdditionOrderService::create([
                        'order_service_id' => $order_service->id,
                        'addition_service_id' => $addition_cart->addition_id,
                        'count' => $addition_cart->count,
                        'addition_service_price' => $addition_cart->Addition->price,
                        'total_price' => $total_addition_price,
                    ]);
                }
            }
            $app_price_from_provider = ($total_order_price * (int)$order->app_precentage_from_provider !=0 ?(int)$order->app_precentage_from_provider: 1) / 100;

            $order->update(['total_order_price' => $total_order_price, 'app_price_from_provider' => $app_price_from_provider]);
            Cart::where('user_id', $user->id)->delete();

            // =========================== Notification ===========================
            $title = trans('app.fcm.title');

            $fcm_data = [];
            $fcm_data['title'] = $title;

            $body_ar = 'قام ' . $request->user()->username . ' بإرسال طلب جديد';
            $body_en = $request->user()->username . ' sent a new order';
            $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

            $fcm_data['key'] = 'user_new_order';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = $request->user()->username;
            $fcm_data['sender_logo'] = $request->user()->profile_image;
            $fcm_data['order_id'] = $order->id;
            $fcm_data['time'] = $order->updated_at->diffforhumans();

            add_notification($order->provider_id, 'order', $order->id, $body_ar, $body_en);

            if (Device::where('user_id', $order->provider_id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->provider_id, $title, $body, $fcm_data, (60 * 20));
            }
            // =========================== Notification ===========================

            DB::commit();
        } catch (Exception $e) {
            dd($e);
            DB::rollback();
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
        return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => null], 200);
    }

    public function create_by_book(Request $request)
    {
        if (!$request->lat || !$request->lng)
            return response()->json(['status' => 'false', 'message' => trans('app.lat_and_lng_required'), 'data' => null], 422);
        if (!User::where('type', 'user')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 404);
        $user = User::where('type', 'user')->find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($request->service_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.service_id_required'), 'data' => null], 422);
        if (!Service::find($request->service_id))
            return response()->json(['status' => 'false', 'message' => trans('app.service_not_found'), 'data' => null], 404);
        DB::beginTransaction();
        try {
            $service = Service::find($request->service_id);
            $order = Order::create([
                'user_id' => $user->id,
                'provider_id' => $service->provider_id,
                'category_id' => $service->category_id,
                'order_category_type' => $service->Category->type,
                'delivery_price' => 0,
                'order_status' => 'services_client_waiting',
                'app_precentage_from_provider' => settings('app_precentage_from_provider'),
                'lat' => $request->lat,
                'lng' => $request->lng,
                'details' => @$request->details,
                'is_deliverable'=>$service->Category->is_deliverable
            ]);
            $service_price = $service->has_offer == 'no' ? $service->price : ($service->price - ($service->price * $service->offer_price) / 100);
            $booking_order = BookingOrder::create([
                'order_id' => $order->id,
                'service_id' => $service->id,
                'service_price' => $service_price,
            ]);
            $order->update(['total_order_price' => $service_price]);

            // =========================== Notification ===========================
            $title = trans('app.fcm.title');

            $fcm_data = [];
            $fcm_data['title'] = $title;

            $body_ar = 'قام ' . $request->user()->username . ' بإرسال طلب جديد';
            $body_en = $request->user()->username . ' sent a new order';
            $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

            $fcm_data['key'] = 'user_new_order';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = $request->user()->username;
            $fcm_data['sender_logo'] = $request->user()->profile_image;
            $fcm_data['order_id'] = $order->id;
            $fcm_data['time'] = $order->updated_at->diffforhumans();

            add_notification($order->provider_id, 'order', $order->id, $body_ar, $body_en);

            if (Device::where('user_id', $order->provider_id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->provider_id, $title, $body, $fcm_data, (60 * 20));
            }
            // =========================== Notification ===========================

            DB::commit();
        } catch (Exception $e) {
            dd($e);
            DB::rollback();
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
        return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => null], 200);
    }

    /**
     * create new order by user api
     *
     * @return \Illuminate\Http\Response
     */
    public function my_orders(Request $request)
    {
        if (!User::where('type', 'user')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 404);
        $user = User::where('type', 'user')->find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        try {
            return response()->json([
                'status' => 'true',
                'message' => '',
                'data' => MiniUserOrder::collection(Order::where('user_id', $user->id)->orderBy('created_at', 'DESC')->get())
            ], 200);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
    }

    /**
     * order details for user api
     *
     * @return \Illuminate\Http\Response
     */
    public function details(Request $request, $order_id = null)
    {
        if (!User::where('type', 'user')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 404);
        $user = User::where('type', 'user')->find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($order_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.order_id_required'), 'data' => null], 401);
        if (!Order::where(['id' => $order_id, 'user_id' => $user->id])->first())
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

    public function finish_order(Request $request, $order_id = null)
    {
        if (!User::where('type', 'user')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 404);
        $user = User::where('type', 'user')->find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($request->rate == null)
            return response()->json(['status' => 'false', 'message' => trans('app.rate_required'), 'data' => null], 401);
        if ($request->reason == null)
            return response()->json(['status' => 'false', 'message' => trans('app.reason_required'), 'data' => null], 401);
        if ($order_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.order_id_required'), 'data' => null], 401);
        if (!Order::find($order_id))
            return response()->json(['status' => 'false', 'message' => trans('app.order_not_found'), 'data' => null], 404);
        if (!Order::where(['user_id' => $user->id])->whereIn('order_status', ['services_finished_order_without_rate', 'products_finished_order_without_rate'])->find($order_id))
            return response()->json(['status' => 'false', 'message' => trans('app.can_not_accept_or_reject_this_order'), 'data' => null], 505);
        try {
            $order = Order::find($order_id);
            if ($order->order_category_type == 'products') {
                $order->update(['order_status' => 'products_finished_order_with_rate']);
            } else {
                $order->update(['order_status' => 'services_finished_order_with_rate']);
            }
            ProviderRate::create([
                'user_id' => $user->id,
                'provider_id' => $order->provider_id,
                'order_id' => $order->id,
                'rate' => $request->rate,
                'reason' => $request->reason,
            ]);
            Provider::where('user_id', $order->provider_id)->first()->update(['rate_avg' => rate_provider($order->provider_id)]);
            $user = User::find($order->provider_id);
            $user->balance += $order->total_order_price;
            if ($order->order_category_type == 'products' && $order->has_provider_delegate == 'no') {
                $user->delivery_balance += $order->delivery_price;
            }
            $user->debt += $order->app_price_from_provider;
            $user->save();
            // =========================== Notification ===========================
            $title = trans('app.fcm.title');

            $fcm_data = [];
            $fcm_data['title'] = $title;

            $body_ar = 'قام ' . $request->user()->username . ' بتقييم الطلب';
            $body_en = $request->user()->username . ' has rated the order';
            $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

            $fcm_data['key'] = 'user_finish_order';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = $request->user()->username;
            $fcm_data['sender_logo'] = $request->user()->profile_image;
            $fcm_data['order_id'] = $order->id;
            $fcm_data['time'] = $order->updated_at->diffforhumans();

            add_notification($order->provider_id, 'order', $order->id, $body_ar, $body_en);

            if (Device::where('user_id', $order->provider_id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->provider_id, $title, $body, $fcm_data, (60 * 20));
            }

            if ($order->delegate_id != null) {
                add_notification($order->delegate_id, 'order', $order->id, $body_ar, $body_en);

                if (Device::where('user_id', $order->delegate_id)->exists()) {
                    NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->delegate_id, $title, $body, $fcm_data, (60 * 20));
                }
            }
            // =========================== Notification ===========================
            return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => new OrderDetails(Order::find($order_id))], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
    }

    public function retrieve_order(Request $request, $order_id = null)
    {
        if (!User::where('type', 'user')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 404);
        $user = User::where('type', 'user')->find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($order_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.order_id_required'), 'data' => null], 401);
        if (!Order::find($order_id))
            return response()->json(['status' => 'false', 'message' => trans('app.order_not_found'), 'data' => null], 404);
        if (!Order::where(['user_id' => $user->id])->whereIn('order_status', ['services_finished_order_without_rate', 'services_finished_order_with_rate', 'products_finished_order_without_rate', 'products_finished_order_with_rate'])->find($order_id))
            return response()->json(['status' => 'false', 'message' => trans('app.can_not_accept_or_reject_this_order'), 'data' => null], 505);
        try {
            $order = Order::find($order_id);
            $order->update(['retrieve_step' => 'waiting']);
            return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => new OrderDetails(Order::find($order_id))], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
    }

    public function cancel_order(Request $request, $order_id = null)
    {
        if (!User::where('type', 'user')->find($request->user()->id))
            return response()->json(['status' => 'false', 'message' => trans('app.user_not_found'), 'data' => null], 404);
        $user = User::where('type', 'user')->find($request->user()->id);
        if ($user->active != 'active')
            return response()->json(['status' => 'false', 'message' => trans('auth.deactivated_account'), 'data' => null], 403);
        if ($user->banned != '0')
            return response()->json(['status' => 'false', 'message' => trans('auth.banned_account'), 'data' => null], 401);
        if ($order_id == null)
            return response()->json(['status' => 'false', 'message' => trans('app.order_id_required'), 'data' => null], 401);
        if (!Order::find($order_id))
            return response()->json(['status' => 'false', 'message' => trans('app.order_not_found'), 'data' => null], 404);
        if (!Order::where(['user_id' => $user->id])->whereIn('order_status', ['products_client_waiting', 'services_client_waiting'])->find($order_id))
            return response()->json(['status' => 'false', 'message' => trans('app.not_allowed_to_modify'), 'data' => null], 505);

        try {
            $order = Order::find($order_id);
            if ($order->order_category_type == 'products') {
                $order->update(['order_status' => 'products_client_cancel']);
            } else {
                $order->update(['order_status' => 'services_client_cancel']);
            }

            // =========================== Notification ===========================
            // $title = trans('app.fcm.title');

            // $fcm_data = [];
            // $fcm_data['title'] = $title;

            // $body_ar = 'قام ' . $request->user()->username . ' بإلغاء الطلب رقم ' . $order->id;
            // $body_en = $request->user()->username . ' has cancel order No. ' . $order->id;
            // $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;

            // $fcm_data['key'] = 'client_cancel_order';
            // $fcm_data['body'] = $body;
            // $fcm_data['msg_sender'] = $request->user()->username;
            // $fcm_data['sender_logo'] = $request->user()->profile_image;
            // $fcm_data['order_id'] = $order->id;
            // $fcm_data['time'] = $order->updated_at->diffforhumans();

            // add_notification($order->provider_id, 'order', $order->id, $body_ar, $body_en);

            // if (Device::where('user_id', $order->provider_id)->exists()) {
            //     NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->provider_id, $title, $body, $fcm_data, (60 * 20));
            // }

            // if ($order->delegate_id != null) {
            //     add_notification($order->delegate_id, 'order', $order->id, $body_ar, $body_en);

            //     if (Device::where('user_id', $order->delegate_id)->exists()) {
            //         NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($order->delegate_id, $title, $body, $fcm_data, (60 * 20));
            //     }
            // }
            // =========================== Notification ===========================
            return response()->json(['status' => 'true', 'message' => trans('app.sent_successfully'), 'data' => new OrderDetails(Order::find($order_id))], 200);
        } catch (Exception $e) {
            return response()->json(['status' => 'false', 'message' => trans('auth.something_went_wrong_please_try_again'), 'data' => null], 401);
        }
    }
}
