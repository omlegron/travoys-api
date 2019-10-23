<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Highway extends Model
{
    protected $fillable = [
        'name',
        'start_latitude',
        'start_longitude',
        'end_latitude',
        'end_longitude',
    ];

    public function restArea() {
        return $this->hasMany('App\RestArea');
    }
}
