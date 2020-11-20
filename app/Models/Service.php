<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $table = 'services';

    protected $fillable = [
        'category_provider_id', 'provider_id', 'category_id', 'subcategory_id', 'subcategory_tag_id', 'name', 'price', 'has_offer',
        'offer_price', 'description', 'lat', 'lng', 'far_enough', 'execution_time', 'availability', 'views_count',
        'provider_mobile'
    ];

    public function Images()
    {
        return $this->hasMany('App\Models\ImageService', 'service_id');
    }

    public function Rates()
    {
        return $this->hasMany(ServiceRate::class, 'service_id');
    }

    public function Additions()
    {
        return $this->hasMany('App\Models\AdditionService', 'service_id');
    }

    public function CategoryProvider()
    {
        return $this->belongsTo('App\Models\CategoryProvider', 'category_provider_id');
    }

    public function Porivder()
    {
        return $this->belongsTo('App\User', 'provider_id');
    }

    public function Category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function Subcategory()
    {
        return $this->belongsTo('App\Models\Subcategory', 'subcategory_id');
    }

    public function delete()
    {
        foreach ($this->Images as $image) {
            $image->delete();
        }
        parent::delete();
    }
}
