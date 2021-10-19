<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDecline extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_tbl_id',
        'technician_id',
        'status'
    ];
}
