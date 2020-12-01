<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShowCounterToBookingAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('booking_ads', function (Blueprint $table) {
            $table->integer('counter_views')->default(0);
            $table->integer('counter_clicks')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('booking_ads', function (Blueprint $table) {
            $table->dropColumn('counter_views');
            $table->dropColumn('counter_clicks');
        });
    }
}
