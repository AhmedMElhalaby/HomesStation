<?php

namespace App\Console\Commands;

use App\Models\Subscription;
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
        $Subscriptions = Subscription::where('expiration_notified',false)->where('expire_at','<=',Carbon::today()->addDays(7))->get();

    }
}
