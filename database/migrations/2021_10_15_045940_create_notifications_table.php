<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');            
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('role_id');            
            $table->foreign('role_id')->references('id')->on('roles');
            $table->string('order_id');
            $table->unsignedBigInteger('order_tbl_id');
            $table->foreign('order_tbl_id')->references('id')->on('orders');
            $table->string('message');
            $table->string('deep_link')->nullable();
            $table->enum('is_sent',[0,1])->default(0);
            $table->enum('is_seen',[0,1])->default(0);
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
        Schema::dropIfExists('notifications');
    }
}
