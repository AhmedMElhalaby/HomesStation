<?php

namespace App\Http\Resources;

use App\Models\BookingAds;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\City as CityModel;
use App\Models\Nationality as NationalityModel;

class MiniProviderResource extends JsonResource
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
            'mobile' => $this->mobile,
            'profile_image' => $this->profile_image,
            'city' => $this->city_id == 0 ? 0 : new City(CityModel::find($this->city_id)),
            'is_verified' => $this->is_verified,
            'store_name' => $this->ProviderData->store_name,
            'minimum_charge' => $this->ProviderData->minimum_charge,
            'opening_time' => $this->ProviderData->opening_time,
            'closing_time' => $this->ProviderData->closing_time,
            'availability' => $this->ProviderData->availability,
            'is_fav' => $request->user() == null ? '0' : is_fav_provider($this->id, $request->user()->id),
            'rate_avg' => number_format((float)$this->ProviderData->rate_avg, 1, '.', ''),
            'lat' => $this->lat,
            'lng' => $this->lng,
            'product_count' => $this->Services->count(),
            'offer_count' => $this->Services->where('has_offer' , 'yes')->count(),
            'ads_count'=>BookingAds::where('user_id',$this->id)->count(),
        ];
    }
}
