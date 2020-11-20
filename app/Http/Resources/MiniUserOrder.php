<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Order\Services\MiniUserOrder as MiniOrderServices;
use App\Http\Resources\Order\Products\MiniUserOrder as MiniOrderProducts;
use App\Models\Order;

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
        if ($this->order_category_type == 'products') {
            return new MiniOrderProducts(Order::find($this->id));
        } else {
            return new MiniOrderServices(Order::find($this->id));
        }
    }
}
