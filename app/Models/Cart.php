<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
            'user_id',
            'category_id',
            'service_id',
            'booking_date',
            'time_slot_id',
            'description',
    ];

    public function services()
    {
        return $this->hasOne(Service::class,'id','service_id');
    }

    public function time_slots()
    {
        return $this->hasOne(TimeSlot::class,'id','time_slot_id');
    }
}