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
            $fcm_data = [];
            $title = app()->getLocale() == 'ar' ? 'تذكير الاشتراك' : 'Subscription reminder';
            $body = app()->getLocale() == 'ar' ? 'اشتراكك على وشك الانتهاء' : 'Your Subscription is about to Expire';
            $fcm_data['title'] = $title;
            $fcm_data['key'] = 'new_order';
            $fcm_data['body'] = $body;
            if (Device::where('user_id', $user->id)->exists()) {
                NotificationController::SEND_SINGLE_STATIC_NOTIFICATION($user->id,$title, $body, $fcm_data, (60 * 20));
            }
            $user->expiration_notification = true;
            $user->save();
        }
    }
}
