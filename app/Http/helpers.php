<?php 

function filter_mobile_number($mob_num)
{
    $first_3_val = substr($mob_num, 0, 3);
    $sixth_val = substr($mob_num, 0, 6);
    $fifth_val = substr($mob_num, 0, 5);
    $first_val = substr($mob_num, 0, 1);
    $mob_number = 0;
    $val = 0;
    if ($sixth_val == "009665") {
        $val = null;
        $mob_number = substr($mob_num, 2);
    } elseif ($fifth_val == "00966") {
        $val = null;
        $mob_number = substr($mob_num, 2);
    } elseif ($first_3_val == "+96") {
        $val = "966";
        $mob_number = substr($mob_num, 4);
    } elseif ($first_3_val == "966") {
        $val = null;
        $mob_number = $mob_num;
    } elseif ($first_val == "5") {
        $val = "966";
        $mob_number = $mob_num;
    } elseif ($first_3_val == "009") {
        $val = "966";
        $mob_number = substr($mob_num, 4);
    } elseif ($first_val == "0") {
        $val = "966";
        $mob_number = substr($mob_num, 1);
    } else {
        $val = "966";
        $mob_number = $mob_num;
    }
    $real_mob_number = $val . $mob_number;
    return $real_mob_number;
}

function generate_code()
{
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $token = '';
    $length = 6;
    for ($i = 0; $i < $length; $i++) {
        $token .= $characters[rand(0, $charactersLength - 1)];
    }
    return $token;
}

function add_notification($user_id, $key, $key_id, $msg_ar, $msg_en)
{
    $new_notification = new App\Models\Notification();
    $new_notification->user_id = $user_id;
    $new_notification->key = $key;
    $new_notification->key_id = $key_id;
    $new_notification->msg_ar = $msg_ar;
    $new_notification->msg_en = $msg_en;
    $new_notification->is_seen = 'unseen';
    $new_notification->save();
    return true;
}

function settings($param)
{
    return App\Models\Setting::where('key', $param)->first()->value;
}

function rate_provider($provider_id)
{
    return number_format((\App\Models\ProviderRate::where('provider_id', $provider_id)->avg('rate')), 1, '.', '');
}

function is_fav_service($service_id, $user_id)
{
    if (\App\Models\FavService::where(['user_id' => $user_id, 'service_id' => $service_id])->first()) {
        return '1';
    } else {
        return '0';
    }
}

function is_fav_provider($provider_id, $user_id)
{
    if (\App\Models\FavProvider::where(['user_id' => $user_id, 'provider_id' => $provider_id])->first()) {
        return '1';
    } else {
        return '0';
    }
}

function cart_block_price($cart_id)
{
    $cart = App\Models\Cart::find($cart_id);
    $service = $cart->Service;
    $price = $service->has_offer == 'yes' ? ($service->price - ($service->price * $service->offer_price) / 100) : $service->price;
    return $cart->count * $price;
}

function get_total_additions_price($cart_id)
{
    $additions_cart = App\Models\AdditionCart::where('cart_id', $cart_id)->get();
    $total_price = 0;
    foreach ($additions_cart as $addition_cart) {
        $total_price += $addition_cart->count * $addition_cart->Addition->price;
    }
    return $total_price;
}

function get_total_additions_order_price($order_service_id)
{
    $additions_order = App\Models\AdditionOrderService::where('order_service_id', $order_service_id)->get();
    $total_price = 0;
    foreach ($additions_order as $addition_order) {
        $total_price += $addition_order->count * $addition_order->Addition->price;
    }
    return $total_price;
}

function total_order_profit($date, $key)
{
    return App\Models\Order::where('created_at', 'LIKE', $date . '%')->get()->sum($key);
}

function order_status($order_status)
{
    if ($order_status == 'products_client_waiting') {
        return trans('app.order_status.products.client_waiting'); // في انتظار مقدم الخدمة يوافق على الطلب
    } elseif ($order_status == 'client_cancel') {
        return trans('app.order_status.products.client_cancel'); // قام العميل بإلغاء الطب
    } elseif ($order_status == 'products_provider_accepted_and_search_about_delegate') {
        return trans('app.order_status.products.provider_accepted_and_search_about_delegate'); // مقدم الخدمة وافق على الطلب وهيتم البحث عن مندوب يوصل الطلب
    } elseif ($order_status == 'products_provider_accepted_and_provider_will_be_delivered_the_order') {
        return trans('app.order_status.products.provider_accepted_and_provider_will_be_delivered_the_order'); // مقدم الخدمة وافق على الطلب وهو عنده مندوب للتوصيل
    } elseif ($order_status == 'products_provider_rejected') {
        return trans('app.order_status.products.provider_rejected'); // الطلب مرفوض من مقدم الخدمة
    } elseif ($order_status == 'products_delegate_accepted_order_being_processed') {
        return trans('app.order_status.products.delegate_accepted_order_being_processed'); // الطلب جاري العمل عليه و المندوب وافق يوصل الطلب
    } elseif ($order_status == 'products_order_processed_delegate_waiting_to_accept') {
        return trans('app.order_status.products.order_processed_delegate_waiting_to_accept'); // الطلب انتهي ولسه المندوب موافقش يوصل
    } elseif ($order_status == 'products_order_processed_delegate_waiting_to_receive') {
        return trans('app.order_status.products.order_processed_delegate_waiting_to_receive'); // الطلب انتهي وفي انتظار المندوب اللي وافق على الطلب يجي يستلمه
    } elseif ($order_status == 'products_delegate_on_the_way') {
        return trans('app.order_status.products.delegate_on_the_way'); // في حالة المندوب لما يستلم الطلب او ان الاسرة هي اللي معاها المندوب وهي اللي هتسلم الطلب
    } elseif ($order_status == 'products_finished_order_without_rate') {
        return trans('app.order_status.products.finished_order_without_rate');
    } elseif ($order_status == 'products_finished_order_with_rate') {
        return trans('app.order_status.products.finished_order_with_rate');
    } elseif ($order_status == 'services_client_waiting') {
        return trans('app.order_status.services.client_waiting');
    } elseif ($order_status == 'services_provider_accepted') {
        return trans('app.order_status.services.provider_accepted');
    } elseif ($order_status == 'services_provider_rejected') {
        return trans('app.order_status.services.provider_rejected');
    } elseif ($order_status == 'services_delegate_on_the_way') {
        return trans('app.order_status.services.delegate_on_the_way');
    } elseif ($order_status == 'services_finished_order_without_rate') {
        return trans('app.order_status.services.finished_order_without_rate');
    } elseif ($order_status == 'services_finished_order_with_rate') {
        return trans('app.order_status.services.finished_order_with_rate');
    }
}

function calc_expire_date($period_type, $period)
{
    // dd($period_type . '  -  '. $period);
    $subscription_end_date = '';
    if ($period_type == 'hours') {
        $subscription_end_date = \Carbon\Carbon::now()->addHours($period);
    } elseif ($period_type == 'days') {
        $subscription_end_date = \Carbon\Carbon::now()->addDays($period);
    } elseif ($period_type == 'weeks') {
        $subscription_end_date = \Carbon\Carbon::now()->addWeeks($period);
    } elseif ($period_type == 'months') {
        $subscription_end_date = \Carbon\Carbon::now()->addMonths($period);
    } elseif ($period_type == 'years') {
        $subscription_end_date = \Carbon\Carbon::now()->addYears($period);
    }
    return $subscription_end_date;
}