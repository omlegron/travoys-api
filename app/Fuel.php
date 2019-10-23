<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fuel extends Model
{
    public function restArea()
    {
        return $this->belongsTo(RestArea::class);
    }
}
