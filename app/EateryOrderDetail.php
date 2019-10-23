<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EateryOrderDetail extends Model
{
    protected $fillable = [
        'eatery_order_id',
        'eatery_menu_id',
        'count',
    ];

    public static function rules($update = false, $id = null)
    {
        $rules = [
            'eatery_order_id'       => 'required',
            'eatery_menu_id'        => 'required',
            'count'                 => 'required',
        ];
        if ($update) {
            return $rules;
        }
        return array_merge($rules, []);
    }

    public function menu()
    {
        return $this->hasOne('App\EateryMenu', 'id', 'eatery_menu_id');
    }
}
