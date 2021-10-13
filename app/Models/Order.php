<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;


     protected $fillable = [
            'order_id',
            'order_amount',
            'final_payment',
            'mobile',
            'user_id',
            'category_id',
            'service_id',
            'booking_date',
            'time_slot_id',
            'booking_time',
            'technician_id',
            'description',
            'service_name',
            'address',
            'service_detail',
            'cart_detail',
            'status',
            'admin_payment_status'
    ];

    public function users(){
      return $this->hasOne(User::class,'id','user_id');
  }

   public function categories(){
      return $this->hasOne(Category::class,'id','category_id');
  }

   public function services(){
      return $this->hasOne(Service::class,'id','service_id');
  }

   public function technicians(){
      return $this->hasMany(Technician::class,'category_id','category_id');
  }
}
