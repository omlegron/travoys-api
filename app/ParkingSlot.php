<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkingSlot extends Model
{
    protected $fillable = ['slots'];

    public function restArea()
    {
        return $this->belongsTo(RestArea::class);
    }
}
