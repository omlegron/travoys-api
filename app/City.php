<?php

namespace App;

use Malhal\Geographical\Geographical;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use Geographical;

    /**
     * Set default distance value to kilometer
     *
     * @var boolean
     */
    protected static $kilometers = true;

    /**
     * Get the places in the city.
     */
    public function places()
    {
        return $this->hasMany('App\Place');
    }
}
