<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ratting extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_tbl_id',
        'user_id',
        'technician_id',
        'ratting_star',
        'comment'
    ];
}
