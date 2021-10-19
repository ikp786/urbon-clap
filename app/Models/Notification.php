<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
	use HasFactory;

	protected $fillable = [	
			'user_id',
			'role_id',
			'order_id',
			'order_tbl_id',
			'message',
			'deep_link',
			'is_sent',
			'is_seen'
		];
}
