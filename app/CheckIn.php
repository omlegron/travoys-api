<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CheckIn extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'rest_area_id',
        'in',
        'out',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'out',
        'in',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function restArea()
    {
        return $this->belongsTo(RestArea::class);
    }
}
