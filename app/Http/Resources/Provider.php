<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\City as CityModel;
use App\Models\Nationality as NationalityModel;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Provider extends JsonResource implements JWTSubject
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
            'token' => ['token_type' => 'Bearer', 'access_token' => JWTAuth::fromUser($this)],
            'city' => $this->city_id == 0 ? 0 : new City(CityModel::find($this->city_id)),
            'nationality' => $this->nationality_id == 0 ? 0 : new Nationality(NationalityModel::find($this->nationality_id)),
            'is_verified' => $this->is_verified,
            'store_name' => $this->ProviderData->store_name,
            'opening_time' => $this->ProviderData->opening_time,
            'closing_time' => $this->ProviderData->closing_time,
            'minimum_charge' => $this->ProviderData->minimum_charge,
            'availability' => $this->ProviderData->availability,
            'is_fav' => $request->user() == null ? '0' : is_fav_provider($this->id, $request->user()->id),
            'rate_avg' => number_format((float)$this->ProviderData->rate_avg,1,'.',''),
            'commercial_register_number' => $this->ProviderData->commercial_register_number,
            'commercial_register_image' => $this->ProviderData->commercial_register_image400,
        ];
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }
}
