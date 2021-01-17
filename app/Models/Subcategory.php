<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\General\ImageController;

class Subcategory extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id', 'priority', 'name_ar', 'name_en', 'image'
    ];

    protected $appends = ['image200', 'image400', 'image600'];

    public function Category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function Services()
    {
        return $this->hasMany(Service::class);
    }

    public function setImageAttribute($value)
    {
        if (isset($this->attributes['image']) && $this->attributes['image'] != '') {
            if (file_exists(public_path('storage/app/uploads/subcategory/org' . "/" . $this->attributes['image']))) {
                ImageController::delete_image_from_folder($this->attributes['image'], 'app/uploads/subcategory');
            }
        }
        $filename = ImageController::upload_single($value, 'app/uploads/subcategory');
        $this->attributes['image'] = $filename;
    }

    public function getImage200Attribute()
    {
        if ($this->attributes['image'] != "") {
            if (!file_exists(public_path('storage/app/uploads/subcategory/200' . "/" . $this->attributes['image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/subcategory/200') . '/' . $this->attributes['image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }

    public function getImage400Attribute()
    {
        if ($this->attributes['image'] != "") {
            if (!file_exists(public_path('storage/app/uploads/subcategory/400' . "/" . $this->attributes['image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/subcategory/400') . '/' . $this->attributes['image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }

    public function getImage600Attribute()
    {
        if ($this->attributes['image'] != "") {
            if (!file_exists(public_path('storage/app/uploads/subcategory/600' . "/" . $this->attributes['image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/subcategory/600') . '/' . $this->attributes['image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }
}
