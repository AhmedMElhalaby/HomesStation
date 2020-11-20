<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubcategoryTag extends Model
{

    protected $table = "subcategory_tags";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subcategory_id', 'name_ar', 'name_en'
    ];

    public function Subcategory()
    {
        return $this->belongsTo(Subcategory::class, 'subcategory_id');
    }

    public function Services()
    {
        return $this->hasMany(Service::class);
    }
}
