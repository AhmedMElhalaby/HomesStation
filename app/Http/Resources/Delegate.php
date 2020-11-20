<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\City as CityModel;
use App\Models\Nationality as NationalityModel;

class Delegate extends JsonResource
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
            'fullname' => $this->fullname,
            'type' => $this->type,
            'mobile' => $this->mobile,
            'email' => $this->email == null ? '' : $this->email,
            'active' => $this->active,
            'profile_image' => $this->profile_image,
            'license_image' => $this->license_image_url,
            'lang' => $this->lang,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'identity_number' => $this->identity_number,
            'nationality' => $this->nationality_id == 0 ? 0 : new Nationality(NationalityModel::find($this->nationality_id)),
            'city' => $this->city_id == 0 ? 0 : new City(CityModel::find($this->city_id)),
        ];
    }
}
