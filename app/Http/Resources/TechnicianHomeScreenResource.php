<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TechnicianHomeScreenResource extends JsonResource
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

            'name'                      => $this->name,
            'online_status'             => $this->online_status,
            'category_name'             => $this->categories->name,
            'profile_pic'            => !empty($this->profile_pic) ? asset('storage/app/public/user_image/'.$this->profile_pic) : asset('storage/app/public/user_image/user-default-pic.png'),                       
        ];
    }
}
