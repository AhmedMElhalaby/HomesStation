<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\OrderService;

class OrderDetails extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'order_status_key' => $this->order_status,
            'order_status_translated' => order_status($this->order_status),
            'delivery_price' => $this->delivery_price,
            'total_order_price' => $this->total_order_price,
            'has_provider_delegate' => $this->has_provider_delegate,
            'user_location' => ['lat' => $this->lat, 'lng' => $this->lng],
            'provider_location' => ['lat' => $this->Provider->lat, 'lng' => $this->Provider->lng],
            'delegate_location' => $this->Delegate == null ? null : ['lat' => $this->Delegate->lat, 'lng' => $this->Delegate->lng],
            'user_data' => new MiniUserResource($this->User),
            'provider_data' => new MiniProviderResource($this->Provider),
            'delegate_data' => new MiniDelegateResource($this->Delegate),
            'details'=>$this->details
        ];
        if ($this->order_category_type == 'products') {
            $data['products_order'] = OrderServices::collection(OrderService::where('order_id', $this->id)->get());
            $data['service_data'] = null;
        } else {
            $data['products_order'] = null;
            $data['service_data'] = $this->BookingOrder ? new MiniServiceResource($this->BookingOrder->Service) : '';
        }
        // $data['created_seconds'] = strtotime($this->created_at);
        $data['created_seconds'] = $this->created_at->diffInSeconds(now());
        $data['created_time'] = $this->created_at->diffforhumans();
        return $data;
    }
}
