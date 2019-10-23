<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RestAreaPlace extends Model
{
    protected $fillable = [
        'image',
        'name',
        'rest_area_id',
        'rest_area_place_type_id',
        'longitude',
        'latitude',
    ];

    public function type()
    {
        return $this->hasOne('App\RestAreaPlaceType', 'id', 'rest_area_place_type_id');
    }

    public function facility()
    {
        return $this->hasMany('App\RestAreaPlaceFacility', 'rest_area_place_id', 'id');
    }
}
