<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleClass extends Model
{
    protected $table = 'vehicle_classes';

    protected $guarded = ['id'];
    
    public static function rules($update = false, $id = null)
    {
        $rules = [
            'class_name'    => 'required',
        ];
        if ($update) {
            return $rules;
        }
        return array_merge($rules, []);
    }

    public function details() {
        return $this->hasMany('App\VehicleClassDetail', 'vehicle_class_id', 'id');
    }
}
