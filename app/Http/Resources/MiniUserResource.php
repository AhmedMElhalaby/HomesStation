<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\City as CityModel;

class MiniUserResource extends JsonResource
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
            'username' => $this->username,
            'type' => $this->type,
            'mobile' => $this->mobile,
            'email' => $this->email == null ? '' : $this->email,
            'profile_image' => $this->profile_image,            
            'city' => $this->city_id == 0 ? 0 : new City(CityModel::find($this->city_id)),
        ];
    }
}
