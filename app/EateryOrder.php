<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EateryOrder extends Model
{
    protected $fillable = [
        'code',
        'user_id',
        'eatery_id',
        'total',
        'status',
    ];

    public static function rules($update = false, $id = null)
    {
        $rules = [
            'eatery_id' => 'required',
        ];
        if ($update) {
            return $rules;
        }
        return array_merge($rules, []);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function orders()
    {
        return $this->hasMany('App\EateryOrderDetail')->with('menu');
    }
}
