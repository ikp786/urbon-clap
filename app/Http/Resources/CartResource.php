<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
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
            'cart_id'                =>   $this->id,
            'service_id'             =>   $this->services->id,
            'service_name'           =>   $this->services->name,
            'service_amount'         =>   $this->services->service_amount,
            'description'            =>   $this->description,
            'services_thumbnail'     =>   !empty($this->services->service_thumbnail) ? asset('storage/app/public/service/'.$this->services->service_thumbnail) : asset('storage/app/public/user_image/user-default-pic.png'),
            'booking_date'           =>   $this->booking_date,
            'booking_time'           =>   $this->time_slots->slot,
        ];
    }
}
