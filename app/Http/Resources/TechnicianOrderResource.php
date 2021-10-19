<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Technician;

class TechnicianOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {        
        $data =  [
            'order_id'               => $this->order_id,
            'booking_date'           => $this->booking_date,
            'booking_time'           => $this->booking_time,
            'service_name'           => $this->services->name,
            'status'                 => $this->status,
            'final_payment'          => $this->final_payment,
            'address'                => $this->address,
            'customer_name'          => $this->users->name,
            'customer_mobile'        => $this->users->mobile,
            'task_description'       => $this->description,

        ];        
        return $data;
    }
}