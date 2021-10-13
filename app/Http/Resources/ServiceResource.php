<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CategoryResource;
class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        
     return [
        'service_id'               => $this->id,        
        'service_name'             => $this->name,
        'service_amount'         => $this->service_amount,            
        'service_description'         => $this->service_description,
        'service_thumbnail'            => !empty($this->service_thumbnail) ? asset('storage/app/public/service/'.$this->service_thumbnail) : asset('storage/app/public/user_image/user-default-pic.png'),  
        // new UserResource($this->user)                     
        'category_data'=> new CategoryResource($this->categories)
    ];
}
}
