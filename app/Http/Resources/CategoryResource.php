<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);        
       return [        
        'category_id'               => $this->id,
        'category_name'             => $this->name,
        'category_thumbnail'            => !empty($this->thumbnail) ? asset('storage/app/public/category/'.$this->thumbnail) : asset('storage/app/public/user_image/user-default-pic.png'),                       
    ];
}
}
