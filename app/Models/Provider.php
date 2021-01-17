<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\General\ImageController;

class Provider extends Model
{

    protected $table = 'providers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'store_name', 'minimum_charge', 'opening_time',
        'closing_time', 'rate_avg', 'commercial_register_number', 'commercial_register_image', 'views_count'
    ];

    protected $appends = ['commercial_register_image200', 'commercial_register_image400', 'commercial_register_image600'];

    public function setMinimumChargeAttribute($value)
    {
        if ($value == null) {
            $this->attributes['minimum_charge'] = 0;
        } else {
            $this->attributes['minimum_charge'] = $value;
        }
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        $current_time = date("H:i");
        return $query->whereTime('opening_time', '<=', $current_time)->whereTime('closing_time', '>=', $current_time)->where('availability', 'available');
    }

    public function setCommercialRegisterNumberAttribute($value)
    {
        if ($value == null) {
            $this->attributes['commercial_register_number'] = '';
        } else {
            $this->attributes['commercial_register_number'] = $value;
        }
    }

    public function setCommercialRegisterImageAttribute($value)
    {
        if (isset($this->attributes['commercial_register_image']) && $this->attributes['commercial_register_image'] != '') {
            if (file_exists(public_path('app/uploads/users/commercial_register_image/org' . "/" . $this->attributes['commercial_register_image']))) {
                ImageController::delete_image_from_folder($this->attributes['commercial_register_image'], 'app/uploads/users/commercial_register_image');
            }
        }
        $filename = ImageController::upload_single($value, 'app/uploads/users/commercial_register_image');
        $this->attributes['commercial_register_image'] = $filename;
    }

    public function getCommercialRegisterImage200Attribute()
    {
        if ($this->attributes['commercial_register_image'] != "") {
            if (!file_exists(public_path('app/uploads/users/commercial_register_image/200' . "/" . $this->attributes['commercial_register_image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/users/commercial_register_image/200') . '/' . $this->attributes['commercial_register_image'];
        } else {
            return asset('storage/uploads/default.png');
        }
    }

    public function getCommercialRegisterImage400Attribute()
    {
        if ($this->attributes['commercial_register_image'] != "") {
            if (!file_exists(public_path('app/uploads/users/commercial_register_image/400' . "/" . $this->attributes['commercial_register_image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/users/commercial_register_image/400') . '/' . $this->attributes['commercial_register_image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }

    public function getCommercialRegisterImage600Attribute()
    {
        if ($this->attributes['commercial_register_image'] != "") {
            if (!file_exists(public_path('app/uploads/users/commercial_register_image/600' . "/" . $this->attributes['commercial_register_image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/users/commercial_register_image/600') . '/' . $this->attributes['commercial_register_image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }
}
