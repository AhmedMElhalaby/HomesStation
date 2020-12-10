<?php

namespace App\Http\Resources;

use App\Models\BookingAds;
use \App\Models\Service;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryProvider extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'category_id' => $this->category_id,
            'name' => $this->Category['name_' . app()->getLocale()],
            'type' => $this->Category->type,
            'ads_count' => BookingAds::where('category_id',$this->category_id)->where('user_id',$this->id)->accepted()->count(),
            'services_count' => Service::where('category_id',$this->category_id)->where('provider_id',$this->id)->count(),
            'image' => $this->Category->image400,
            'Category'=>new Category($this->Category),
            'provider_data' => [
                'id' => $this->Provider->id,
                'username' => $this->Provider->username,
                'profile_image' => $this->Provider->profile_image,
            ],
        ];
    }
}
