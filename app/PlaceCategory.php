<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlaceCategory extends Model
{
    protected $fillable = ['name'];
    /**
     * Get all the places of category.
     */
    public function places()
    {
        return $this->hasMany('App\Place', 'category_id');
    }
}
