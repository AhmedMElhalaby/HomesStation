<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MiniServiceResource extends JsonResource
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
            'CategoryProvider'=>new CategoryProvider($this->CategoryProvider),
            'subcategory_id' => $this->subcategory_id,
            'category_type' => $this->Category->type,
            'name' => $this->name,
            'price' => $this->price,
            'has_offer' => $this->has_offer,
            'is_fav' => $request->user() == null ? '0' : is_fav_service($this->id, $request->user()->id),
            'offer_percentage' => $this->offer_price,
            'offer_price' => $this->offer_price == null ? 0 : ($this->price - ($this->price * $this->offer_price) / 100),
            'description' => $this->description,
            'provider_mobile' => $this->provider_mobile,
            'rate_avg' => $this->Rates()->avg('rate') == null ? 0 : (double) number_format($this->Rates()->avg('rate'), 1, '.', ''),
            'image' => count($this->Images) <= 0 ? '' : $this->Images[0]->image400,
        ];
    }
}
