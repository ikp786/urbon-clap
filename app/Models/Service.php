<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Category;
class Service extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'service_amount',
        'service_description',
        'service_thumbnail',
        'status',
    ];

    public function categories(){
      return $this->hasOne(Category::class,'id','category_id');
  }

  public function getServiceThumbnailAttribute($value)
  {    
    return $value;//!empty($value) ? asset('storage/app/public/service/'.$value) : asset('storage/app/public/service-default/default.jpg');
    
}
}