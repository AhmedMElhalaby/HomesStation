<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Category extends JsonResource
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
            'name' => $this['name_' . app()->getLocale()],
            'type' => $this->type,
            'ads_count' => $this->BookingAd()->accepted()->count(),
            'services_count' => $this->Services()->count(),
            'image' => $this->image400,
            'is_deliverable' => $this->is_deliverable,
        ];
    }
}
