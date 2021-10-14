<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Technician;

class UserOrderResource extends JsonResource
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
        $data =  [
            'order_id'               => $this->order_id,
            'booking_date'           => $this->booking_date,
            'booking_time'           => $this->booking_time,
            'service_name'           => $this->services->name,
            'status'                 => $this->status,
            'final_payment'          => $this->final_payment,
            'address'                => $this->address,
            'service_thumbnail'      => !empty($this->services->service_thumbnail) ? asset('storage/app/public/service/'.$this->services->service_thumbnail) : asset('storage/app/public/user_image/user-default-pic.png'),

        ];

        // If order Status Not Pendig And Canceled and Techinician Not assigned
        if($this->technician_id != null && $this->status != 'Pending' && $this->status != 'Canceled' && $this->status != 'Accepted'){
            $technician_detail = Technician::find($this->technician_id);
            $data['technician_detail']['name'] = $technician_detail['name'];
            $data['technician_detail']['mobile'] = $technician_detail['mobile'];
        }
        return $data;
    }
}