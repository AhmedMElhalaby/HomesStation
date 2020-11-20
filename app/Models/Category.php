<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\General\ImageController;

class Category extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'priority', 'name_ar', 'name_en', 'image', 'type','is_deliverable'
    ];

    protected $appends = ['image200', 'image400', 'image600'];

    public function Providers()
    {
        return $this->belongsToMany('App\User', 'categories_providers', 'category_id', 'user_id')->withTimestamps();
    }

    public function BookingAd()
    {
        return $this->hasMany(BookingAds::class, 'category_id');
    }

    public function Subcategories()
    {
        return $this->hasMany(Subcategory::class, 'category_id');
    }

    public function setImageAttribute($value)
    {
        if (isset($this->attributes['image']) && $this->attributes['image'] != '') {
            if (file_exists(storage_path('app/uploads/category/org' . "/" . $this->attributes['image']))) {
                ImageController::delete_image_from_folder($this->attributes['image'], 'app/uploads/category');
            }
        }
        $filename = ImageController::upload_single($value, 'app/uploads/category');
        $this->attributes['image'] = $filename;
    }

    public function getImage200Attribute()
    {
        if ($this->attributes['image'] != "") {
            if (!file_exists(storage_path('app/uploads/category/200' . "/" . $this->attributes['image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/category/200') . '/' . $this->attributes['image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }

    public function getImage400Attribute()
    {
        if ($this->attributes['image'] != "") {
            if (!file_exists(storage_path('app/uploads/category/400' . "/" . $this->attributes['image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/category/400') . '/' . $this->attributes['image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }

    public function getImage600Attribute()
    {
        if ($this->attributes['image'] != "") {
            if (!file_exists(storage_path('app/uploads/category/600' . "/" . $this->attributes['image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/category/600') . '/' . $this->attributes['image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }
}
