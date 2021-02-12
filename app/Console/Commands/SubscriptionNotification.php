<?php

namespace App\Console\Commands;

use App\Http\Controllers\General\NotificationController;
use App\Models\Device;
use App\Models\Subscription;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SubscriptionNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:SubscriptionNotification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Subscription Expiration Notification';

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
        $Users = User::where('expiration_notification',false)->where('expire_date','<=',Carbon::today()->addDays(7))->get();
        foreach ($Users as $user){
            $title_ar = 'تذكير الاشتراك';
            $title_en = 'Subscription reminder';
            $title = app()->getLocale() == 'ar' ? $title_ar : $title_en;
            $body_ar = 'اشتراكك على وشك الانتهاء';
            $body_en = 'Your Subscription is about to Expire';
            $body = app()->getLocale() == 'ar' ? $body_ar : $body_en;
            $fcm_data = [];
            $fcm_data['title'] = $title;
            $fcm_data['key'] = 'management_message';
            $fcm_data['body'] = $body;
            $fcm_data['msg_sender'] = 'HomesStation';
            $fcm_data['sender_logo'] = asset('storage/app/uploads/default.png');
            $fcm_data['time'] = date('Y-m-d H:i:s');
            add_notification($user->id, 'management_message', 0, $body_ar, $body_en);
            if (Device::where('user_id', $user->id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($user->id,$title, $body, $fcm_data, (60 * 20));
            }
            $user->expiration_notification = true;
            $user->save();
        }
    }
}
