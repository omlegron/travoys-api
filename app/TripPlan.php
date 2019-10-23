<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TripPlan extends Model
{
    protected $table = 'trip_plans';

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'start_location_name',
        'start_location_latitude',
        'start_location_longitude',
        'final_location_name',
        'final_location_latitude',
        'final_location_longitude',
        'departure_date',
        'age',
        'total_passenger',
        'vehicle_class_id',
        'number_plate',
        'passenger_type',
    ];
    
    public static function rules($update = false, $id = null)
    {
        $rules = [
            'start_location_latitude'   => 'required',
            'start_location_longitude'  => 'required',
            'final_location_latitude'   => 'required',
            'final_location_longitude'  => 'required',
            'departure_date'            => 'required',
            'age'                       => 'required',
            'total_passenger'           => 'required',
            // 'vehicle_class_id'          => 'required',
        ];
        if ($update) {
            return $rules;
        }
        return array_merge($rules, []);
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function vehicle_class() {
        return $this->hasOne('App\VehicleClassDetail', 'vehicle_class_id', 'id');
    }
    
}
