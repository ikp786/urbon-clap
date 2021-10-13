<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id');
            $table->decimal('order_amount',8,2);
            $table->decimal('final_payment',8,2)->nullable();
            $table->string('mobile');
            $table->unsignedBigInteger('user_id');            
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->unsignedBigInteger('service_id');
            $table->foreign('service_id')->references('id')->on('services');
            $table->date('booking_date');
            $table->unsignedBigInteger('time_slot_id');
            $table->foreign('time_slot_id')->references('id')->on('time_slots');
            $table->string('booking_time');
            $table->unsignedBigInteger('technician_id')->nullable();
            $table->foreign('technician_id')->references('id')->on('users');
            $table->longText('description')->nullable();
            $table->string('service_name');
            $table->text('address');
            $table->longText('service_detail');
            $table->longText('cart_detail');
            $table->enum('status',['Pending','Accepted','Assigned','In-Process','Completed','Canceled'])->default('Pending');
            $table->enum('admin_payment_status',['Paid','Unpaid'])->default('Unpaid');
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
        Schema::dropIfExists('orders');
    }
}
