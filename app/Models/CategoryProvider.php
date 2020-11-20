<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryProvider extends Model
{

    protected $table = 'categories_providers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'category_id'
    ];

    public function Provider()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function Category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }
}
