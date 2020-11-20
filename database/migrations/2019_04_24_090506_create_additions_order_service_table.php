<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdditionsOrderServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('additions_order_service', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_service_id')->unsigned();
            $table->foreign('order_service_id')->references('id')->on('order_services')->onDelete('cascade');
            $table->integer('addition_service_id')->unsigned();
            $table->foreign('addition_service_id')->references('id')->on('additions_service')->onDelete('cascade');
            $table->integer('count')->default(1);
            $table->double('addition_service_price')->default(0);
            $table->double('total_price')->default(0);
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
        Schema::dropIfExists('additions_order_service');
    }
}
