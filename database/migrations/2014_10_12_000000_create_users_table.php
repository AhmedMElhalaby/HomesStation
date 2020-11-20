<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->default(1)->references('id')->on('roles')->onDelete('cascade');
            $table->enum('type', ['admin', 'user', 'provider', 'delegate'])->default('user');
            $table->string('username')->unique();
            $table->string('fullname')->default('');
            $table->string('mobile')->unique();
            $table->string('email')->default('');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('city_id')->default(0);
            $table->integer('nationality_id')->default(0);
            $table->string('lat')->default('');
            $table->string('lng')->default('');
            $table->enum('active', ['deactive', 'active_mobile', 'active'])->default('active');
            $table->enum('banned', ['0', '1'])->default('0');
            $table->text('ban_reason')->nullable();
            $table->text('avatar')->nullable();
            $table->string('code')->default('');
            $table->string('lang')->default('ar');            
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
