<?php

namespace App\Http\Resources\Auth;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\City as CityModel;
use App\Models\Nationality as NationalityModel;
use App\Http\Resources\City;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Http\Resources\Nationality;

class Delegate extends JsonResource implements JWTSubject
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
            'token' => ['token_type' => 'Bearer', 'access_token' => JWTAuth::fromUser($this)],
            'city' => $this->city_id == 0 ? 0 : new City(CityModel::find($this->city_id)),
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
