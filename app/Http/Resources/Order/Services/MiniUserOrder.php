<?php

namespace App\Http\Resources\Order\Services;

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
            'provider_profile_image' => $this->Provider->profile_image,
            'store_name' => $this->Provider->ProviderData->store_name,
            'service_name' => $this->BookingOrder ?$this->BookingOrder->Service->name : '',
            'products_count' => 1,
            'order_status' => order_status($this->order_status),
            'created_time' => $this->created_at->diffforhumans(),
        ];
    }
}
