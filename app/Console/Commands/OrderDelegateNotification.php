<?php

namespace App\Console\Commands;

use App\Http\Controllers\General\NotificationController;
use App\Models\Device;
use App\Models\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class OrderDelegateNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:OrderDelegateNotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Order Delegate Notification';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $Orders = Order::where('order_status','products_provider_accepted_and_search_about_delegate')->where('last_notify','<=',Carbon::today()->subMinutes(5))->get();
        foreach ($Orders as $order){
            $delegate = User::where('type' , 'delegate')->whereNotIn('id',\App\Models\OrderDelegateNotification::where('order_id',$order->id)->pluck('delegate_id'))->active()->subscribed()->nearest($order->Provider->lat, $order->Provider->lng, settings('num_of_search_km_for_provider'))->first();
            $OrderDelegateNotification = new \App\Models\OrderDelegateNotification();
            $OrderDelegateNotification->order_id = $order->id;
            $OrderDelegateNotification->delegate_id = $delegate->id;
            $OrderDelegateNotification->save();
            $order->last_notify = Carbon::today()->format('Y-m-d');
            $order->save();
            $fcm_data = [];
            $fcm_data['title'] = trans('app.fcm.title');
            $fcm_data['key'] = 'new_order';
            $fcm_data['body'] = app()->getLocale() == 'ar' ? 'طلب جديد' : 'new order';
            $fcm_data['msg_sender'] = $order->Provider->username;
            $fcm_data['sender_logo'] = $order->Provider->profile_image;
            $fcm_data['order_id'] = $order->id;
            $fcm_data['time'] = $order->updated_at->diffforhumans();
            if (Device::where('user_id', $delegate->id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($delegate->id, trans('app.fcm.title'), 'new order', $fcm_data, (60 * 20));
            }
        }
    }
}
