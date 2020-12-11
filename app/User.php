<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Http\Controllers\General\ImageController;
use DB;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role_id', 'type', 'username', 'fullname', 'email', 'password', 'mobile', 'city_id', 'identity_number', 'nationality_id', 'avatar',
        'active', 'banned', 'ban_reason', 'lang', 'code', 'lat', 'lng', 'balance', 'delivery_balance', 'expire_date', 'is_verified', 'license_image','expiration_notification'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['image200', 'image400', 'profile_image', 'license_image_url'];

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

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where(['active' => 'active', 'banned' => '0']);
    }

    public function scopeSubscribed($query)
    {
        return $query->where('expire_date', '>', date('Y-m-d H:i:s'));
    }

    /**
     * Scope a query to only include nearest providers.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNearest($query, $lat, $lng, $space_search_by_kilos)
    {
        $lat = (float) $lat;
        $lng = (float) $lng;
        $space_search_by_kilos = (float) $space_search_by_kilos;
        return $query->select(DB::raw("*,
                            (6378.10 * ACOS(COS(RADIANS($lat))
                                * COS(RADIANS(lat))
                                * COS(RADIANS($lng) - RADIANS(lng))
                                + SIN(RADIANS($lat))
                                * SIN(RADIANS(lat)))) AS distance"))
            ->having('distance', '<=', $space_search_by_kilos)
            ->orderBy('distance', 'asc');
    }

    public function Role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function City()
    {
        return $this->belongsTo('App\Models\City');
    }

    public function Nationality()
    {
        return $this->belongsTo('App\Models\Nationality');
    }

    public function Cart()
    {
        return $this->hasMany('App\Models\Cart');
    }

    public function ProviderData()
    {
        return $this->hasOne('App\Models\Provider', 'user_id', 'id');
    }

    public function FavServices()
    {
        return $this->belongsToMany('App\Models\Service', 'fav_services', 'user_id', 'service_id')->withTimestamps();
    }

    public function FavProviders()
    {
        return $this->belongsToMany(User::class, 'fav_providers', 'user_id', 'provider_id')->withTimestamps();
    }

    public function Categories()
    {
        return $this->belongsToMany('App\Models\Category', 'categories_providers', 'user_id', 'category_id')->withTimestamps();
    }

    public function CategoriesProvider()
    {
        return $this->hasMany('App\Models\CategoryProvider', 'user_id');
    }

    public function Services()
    {
        return $this->hasMany('App\Models\Service', 'provider_id');
    }

    public function DelegateOrders()
    {
        return $this->hasMany('App\Models\Order', 'delegate_id');
    }

    public function ProviderOrders()
    {
        return $this->hasMany('App\Models\Order', 'provider_id');
    }

    public function UserOrders()
    {
        return $this->hasMany('App\Models\Order', 'user_id');
    }

    public function ProviderRates()
    {
        return $this->hasMany('App\Models\ProviderRate', 'provider_id');
    }

    public function setAvatarAttribute($value)
    {
        if (isset($this->attributes['avatar']) && $this->attributes['avatar'] != '') {
            if (file_exists(storage_path('app/uploads/users/avatar/org' . "/" . $this->attributes['avatar']))) {
                ImageController::delete_image_from_folder($this->attributes['avatar'], 'app/uploads/users/avatar');
            }
        }
        $filename = ImageController::upload_single($value, 'app/uploads/users/avatar');
        $this->attributes['avatar'] = $filename;
    }

    public function setLicenseImageAttribute($value)
    {
        if (isset($this->attributes['license_image']) && $this->attributes['license_image'] != '') {
            if (file_exists(storage_path('app/uploads/users/license_image/org' . "/" . $this->attributes['license_image']))) {
                ImageController::delete_image_from_folder($this->attributes['license_image'], 'app/uploads/users/license_image');
            }
        }
        $filename = ImageController::upload_single($value, 'app/uploads/users/license_image');
        $this->attributes['license_image'] = $filename;
    }

    public function setPasswordAttribute($value)
    {
        if (!$value == null) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    public function setEmailAttribute($value)
    {
        if ($value == null) {
            $this->attributes['email'] = '';
        } else {
            $this->attributes['email'] = $value;
        }
    }

    public function getImage200Attribute()
    {
        if ($this->attributes['avatar'] != "") {
            if (!file_exists(storage_path('app/uploads/users/avatar/200' . "/" . $this->attributes['avatar']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/users/avatar/200') . '/' . $this->attributes['avatar'];
        } else {
            return asset('storage/uploads/default.png');
        }
    }

    public function getImage400Attribute()
    {
        if ($this->attributes['avatar'] != "") {
            if (!file_exists(storage_path('app/uploads/users/avatar/400' . "/" . $this->attributes['avatar']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/users/avatar/400') . '/' . $this->attributes['avatar'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }

    public function getProfileImageAttribute()
    {
        if ($this->attributes['avatar'] != "") {
            if (!file_exists(storage_path('app/uploads/users/avatar/600' . "/" . $this->attributes['avatar']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/users/avatar/600') . '/' . $this->attributes['avatar'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }

    public function getLicenseImageUrlAttribute()
    {
        if ($this->attributes['license_image'] != "") {
            if (!file_exists(storage_path('app/uploads/users/license_image/600' . "/" . $this->attributes['license_image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/users/license_image/600') . '/' . $this->attributes['license_image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }
}
