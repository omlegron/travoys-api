<?php

namespace App;

use Malhal\Geographical\Geographical;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use Geographical;

    /**
     * Scope a query to only include popular users.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeHasCoordinates($query)
    {
        return $query->whereNotNull('longitude')->whereNotNull('latitude');
    }

    /**
     * Get the category related to this place.
     */
    public function category()
    {
        return $this->belongsTo('App\PlaceCategory');
    }

    /**
     * Get the city where place is located.
     */
    public function city()
    {
        return $this->belongsTo('App\City');
    }
}
