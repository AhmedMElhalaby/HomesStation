<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\General\ImageController;

class ImageService extends Model
{
    protected $table = 'images_service';

    protected $fillable = ['service_id', 'image'];

    protected $appends = ['image200', 'image400', 'image600'];

    public function Service()
    {
        return $this->belongsTo('App\Models\Service', 'service_id');
    }

    public function delete()
    {
        if (isset($this->attributes['image']) && $this->attributes['image'] != '') {
            if (file_exists(storage_path('app/uploads/service/org' . "/" . $this->attributes['image']))) {
                ImageController::delete_image_from_folder($this->attributes['image'], 'app/uploads/service');
            }
        }
        parent::delete();
    }

    public function setImageAttribute($value)
    {
        if (isset($this->attributes['image']) && $this->attributes['image'] != '') {
            if (file_exists(storage_path('app/uploads/service/org' . "/" . $this->attributes['image']))) {
                ImageController::delete_image_from_folder($this->attributes['image'], 'app/uploads/service');
            }
        }
        return dd($this->Service()->first()->Porivder->name);
        $filename = ImageController::upload_single($value, 'app/uploads/service',2,@$this->Service()->first()->Porivder->name);
        $this->attributes['image'] = $filename;
    }
    public function getImage200Attribute()
    {
        if ($this->attributes['image'] != "") {
            if (!file_exists(storage_path('app/uploads/service/200' . "/" . $this->attributes['image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/service/200') . '/' . $this->attributes['image'];
        } else {
            return asset('storage/uploads/default.png');
        }
    }

    public function getImage400Attribute()
    {
        if ($this->attributes['image'] != "") {
            if (!file_exists(storage_path('app/uploads/service/400' . "/" . $this->attributes['image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/service/400') . '/' . $this->attributes['image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }

    public function getImage600Attribute()
    {
        if ($this->attributes['image'] != "") {
            if (!file_exists(storage_path('app/uploads/service/600' . "/" . $this->attributes['image']))) {
                return asset('storage/app/uploads/default.png');
            }
            return asset('storage/app/uploads/service/600') . '/' . $this->attributes['image'];
        } else {
            return asset('storage/app/uploads/default.png');
        }
    }
}
