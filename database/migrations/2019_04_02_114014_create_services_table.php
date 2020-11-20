<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('provider_id')->unsigned();
            $table->foreign('provider_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->integer('category_provider_id')->unsigned();
            $table->foreign('category_provider_id')->references('id')->on('categories_providers')->onDelete('cascade');
            $table->integer('subcategory_id')->unsigned();
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('cascade');
            $table->string('name')->default('');
            $table->double('price')->default(0);
            $table->enum('has_offer', ['no', 'yes'])->default('no');
            $table->double('offer_price')->default(0);
            $table->string('lat')->default('');
            $table->string('lng')->default('');
            $table->integer('far_enough')->default(0);
            $table->string('execution_time')->default('');
            $table->text('description')->nullable();
            $table->enum('availability', ['available', 'unavailable'])->default('available');
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
        Schema::dropIfExists('services');
    }
}
