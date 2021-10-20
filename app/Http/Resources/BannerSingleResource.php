<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BannerSingleResource extends JsonResource
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

                'title'       => $this->title,
                'banner'      => !empty($this->banner) ? asset('storage/app/public/banner/'.$this->banner) : asset('storage/app/public/user_image/user-default-pic.png'),                       
        ];
    }
}
