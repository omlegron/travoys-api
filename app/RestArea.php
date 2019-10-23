<?php

namespace App;

use Malhal\Geographical\Geographical;
use Illuminate\Database\Eloquent\Model;

class RestArea extends Model
{
    use Geographical;

    protected $fillable = [
        'image',
        'name',
        'route',
        'latitude',
        'longitude',
        'highway_id',
    ];

    /**
     * Set default distance value to kilometer
     *
     * @var boolean
     */
    protected static $kilometers = true;

    /**
     * Get the highway where rest area is located.
     */
    public function highway()
    {
        return $this->belongsTo('App\Highway');
    }

    /**
     * The satgas that belong in the rest area.
     */
    public function satgas()
    {
        return $this->belongsToMany('App\User', 'rest_area_user', 'rest_area_id', 'user_id');
    }

    /**
     * The eateries that belong in the rest area.
     */
    public function eateries()
    {
        return $this->hasMany('App\Eatery');
    }

    public function places()
    {
        return $this->hasMany('App\RestAreaPlace')->with(['type', 'facility']);
    }

    public function parkingSlot()
    {
        return $this->hasOne(ParkingSlot::class);
    }

    public function fuel()
    {
        return $this->hasOne(Fuel::class);
    }

    public function checkIn()
    {
        return $this->hasMany(CheckIn::class);
    }
}
