<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Service extends JsonResource
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
            'category_provider_id' => $this->category_provider_id,
            'subcategory_id' => $this->subcategory_id,
            'category_type' => $this->Category->type,
            'name' => $this->name,
            'price' => $this->price,
            'has_offer' => $this->has_offer,
            'offer_percentage' => $this->offer_price == null ? 0 : $this->offer_price,
            'offer_price' => $this->offer_price == null ? 0 : ($this->price - ($this->price * $this->offer_price) / 100),
            'is_fav' => $request->user() == null ? '0' : is_fav_service($this->id, $request->user()->id), 
            'lat' => $this->lat,
            'lng' => $this->lng,
            'far_enough' => $this->far_enough,
            'execution_time' => $this->execution_time,
            'availability' => $this->availability,
            'provider_mobile' => $this->provider_mobile,
            'description' => $this->description,
            'rate_avg' => $this->Rates()->avg('rate') == null ? 0 : (double)number_format($this->Rates()->avg('rate'), 1, '.', ''),
            'additions' => count($this->Additions) <= 0 ? [] : Addition::collection($this->Additions),
            'images' => count($this->Images) <= 0 ? [] : Image::collection($this->Images),
            'provider_data' => new MiniProviderResource($this->Porivder),
        ];
    }
}
