<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\City as CityModel;

class MiniDelegateOrder extends JsonResource
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
            'user_data' => [
                'id' => $this->User->id,
                'username' => $this->User->username,
                'profile_image' => $this->User->profile_image,
                'city' => $this->User->city_id == 0 ? 0 : new City(CityModel::find($this->User->city_id)),
            ],
            'provider_data' => [
                'id' => $this->Provider->id,
                'username' => $this->Provider->username,
                'profile_image' => $this->Provider->profile_image,
                'city' => $this->Provider->city_id == 0 ? 0 : new City(CityModel::find($this->Provider->city_id)),
            ],
            'order_status' => order_status($this->order_status),
            'created_time' => $this->created_at->diffforhumans(),
            'details'=>$this->details
        ];
    }
}
