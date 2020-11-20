<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Cart extends JsonResource
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
            'name' => $this->Service->name,
            'price' => $this->Service->has_offer == 'yes' ? ($this->Service->price - ($this->Service->price * $this->Service->offer_price) / 100) : $this->Service->price,
            'image' => count($this->Service->Images) > 0 ? $this->Service->Images[0]->image400 : url('../storage/app/uploads/default.png'),
            'count'  => $this->count,
            'additions'  => AdditionCart::collection($this->AdditionCart),
            'total_price'  => get_total_additions_price($this->id) + cart_block_price($this->id),
        ];
    }
}
