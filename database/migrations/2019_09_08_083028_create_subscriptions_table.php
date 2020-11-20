<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name_ar')->default('');
            $table->string('name_en')->default('');
            $table->enum('user_type', ['providers', 'delegates'])->default('providers');
            $table->string('period')->default('');
            $table->enum('period_type', ['hours', 'days', 'weeks', 'months', 'years'])->default('months');
            $table->double('price')->default(0);
            $table->text('image')->nullable();
            $table->text('description_ar')->nullable();
            $table->text('description_en')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
