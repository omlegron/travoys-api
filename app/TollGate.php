<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TollGate extends Model
{
    protected $fillable = [
        'name',
        'latitude',
        'longitude',
        'highway_id',
    ];

    public function highway()
    {
        return $this->belongsTo(Highway::class);
    }
}
