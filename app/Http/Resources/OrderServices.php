<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderServices extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $price = $this->Service->has_offer == 'no' ? $this->Service->price : ($this->Service->price - ($this->Service->price * $this->Service->offer_price) / 100);
        return [
            'name' => $this->Service->name,
            'price' => $price,
            'count' => $this->count,
            'total_product_price' => ($this->count * $price),
            'image' => count($this->Service->Images) > 0 ? $this->Service->Images[0]->image400 : url('../storage/app/uploads/default.png'),
            'additions' => AdditionOrder::collection($this->AdditionOrderService),
            'total_product_card_price' => get_total_additions_order_price($this->id) + ($this->count * $price),
        ];
    }
}
