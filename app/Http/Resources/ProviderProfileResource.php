<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\City as CityModel;
use App\Models\Nationality as NationalityModel;

class ProviderProfileResource extends JsonResource
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
            'lang' => $this->lang,
            'lat' => $this->lat,
            'lng' => $this->lng,
            'nationality' => $this->nationality_id == 0 ? 0 : new Nationality(NationalityModel::find($this->nationality_id)),
            'city' => $this->city_id == 0 ? 0 : new City(CityModel::find($this->city_id)),
            'is_verified' => $this->is_verified,
            'store_name' => $this->ProviderData->store_name,
            'minimum_charge' => $this->ProviderData->minimum_charge,
            'opening_time' => $this->ProviderData->opening_time,
            'closing_time' => $this->ProviderData->closing_time,
            'availability' => $this->ProviderData->availability,
            'is_fav' => $request->user() == null ? '0' : is_fav_provider($this->id, $request->user()->id),
            'rate_avg' => $this->ProviderData->rate_avg,
            'commercial_register_number' => $this->ProviderData->commercial_register_number,
            'commercial_register_image' => $this->ProviderData->commercial_register_image400,
            'categories' => CategoryProvider::collection($this->CategoriesProvider),
        ];
    }
}
