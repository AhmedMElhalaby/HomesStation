<?php

namespace App\Http\Resources;

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
            'ads_count' => $this->Category->BookingAd()->accepted()->count(),
            'image' => $this->Category->image400,
            'provider_data' => [
                'id' => $this->Provider->id,
                'username' => $this->Provider->username,
                'profile_image' => $this->Provider->profile_image,
            ],
        ];
    }
}
