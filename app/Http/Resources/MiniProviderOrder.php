<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\City as CityModel;

class MiniProviderOrder extends JsonResource
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
            'user_profile_image' => $this->User->profile_image,
            'username' => $this->User->username,
            'type' => $this->order_category_type,
            'city' => $this->User->city_id == 0 ? 0 : new City(CityModel::find($this->User->city_id)),
            'order_status' => order_status($this->order_status),
            'created_time' => $this->created_at->diffforhumans(),
            'details'=>$this->details
        ];
    }
}
