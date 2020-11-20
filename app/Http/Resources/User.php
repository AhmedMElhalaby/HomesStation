<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\City as CityModel;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends JsonResource implements JWTSubject
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
            'active' => $this->active,
            'token' => ['token_type' => 'Bearer', 'access_token' => JWTAuth::fromUser($this)],
            'profile_image' => $this->profile_image,
            'lang' => $this->lang,
            'lat' => $this->lat,
            'lng' => $this->lng,
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
