<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\General\ImageController;

class BookingAds extends Model
{
    protected $table = 'booking_ads';

    protected $fillable = ['user_id', 'city_id', 'category_id', 'date_day', 'image', 'acceptable', 'desc'];

    protected $appends = ['image200', 'image400', 'image600'];

    public function User()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }
    
    public function City()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Scope a query to only include active users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAccepted($query)
    {
        return $query->where(['acceptable' => 'accepted']);
    }

    /**
     * Scope a query to only include today ads.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeToday($query)
    {
        $currentDate = date('Y-m-d');
        return $query->whereDate('date_day', $currentDate);
    }

    public function setImageAttribute($value)
    {
        if (isset($this->attributes['image']) && $this->attributes['image'] != '') {
            if (file_exists(storage_path('app/uploads/ads/org' . "/" . $this->attributes['image']))) {
                ImageController::delete_image_from_folder($this->attributes['image'], 'app/uploads/ads');
            }
        }
        $filename = ImageController::upload_single($value, 'app/uploads/ads');
        $this->attributes['image'] = $filename;
    }

    public function getImage200Attribute()
    {
        if ($this->attributes['image'] != "") {
            if (!file_exists(storage_path('app/uploads/ads/200' . "/" . $this->attributes['image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/ads/200') . '/' . $this->attributes['image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }

    public function getImage400Attribute()
    {
        if ($this->attributes['image'] != "") {
            if (!file_exists(storage_path('app/uploads/ads/400' . "/" . $this->attributes['image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/ads/400') . '/' . $this->attributes['image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }

    public function getImage600Attribute()
    {
        if ($this->attributes['image'] != "") {
            if (!file_exists(storage_path('app/uploads/ads/600' . "/" . $this->attributes['image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/ads/600') . '/' . $this->attributes['image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }
}
