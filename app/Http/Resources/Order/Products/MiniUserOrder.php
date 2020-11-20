<?php

namespace App\Http\Resources\Order\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class MiniUserOrder extends JsonResource
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
            'order_category_type' => $this->order_category_type,
            'provider_profile_image' => $this->when($this->Provider,$this->Provider->profile_image),
            'store_name' => $this->when($this->Provider,$this->Provider->ProviderData->store_name),
            'products_count' => $this->when($this->OrderServices,$this->OrderServices->count()),
            'service_name' => null,
            'order_status' => order_status($this->order_status),
            'created_time' => $this->created_at->diffforhumans(),
        ];
    }
}
