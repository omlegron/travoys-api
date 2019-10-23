<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eatery extends Model
{
    protected $guarded = 'id';

    protected $fillable = [
        'name',
        'rest_area_id',
        'contact',
    ];

    public static function rules($update = false, $id = null)
    {
        $rules = [
            'name'    => 'required',
            'rest_area_id'    => 'required',
        ];
        if ($update) {
            return $rules;
        }
        return array_merge($rules, []);
    }

    /**
     * Get the rest area in which eatery reside.
     */
    public function restArea()
    {
        return $this->belongsTo('App\RestArea');
    }

    public function menus() {
        return $this->hasMany('App\EateryMenu');
    }
}
