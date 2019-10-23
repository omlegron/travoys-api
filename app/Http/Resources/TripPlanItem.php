<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripPlanItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->user,
            'start_location_name' => $this->start_location_name,
            'start_location_latitude' => $this->start_location_latitude,
            'start_location_longitude' => $this->start_location_longitude,
            'final_location_name' => $this->final_location_name,
            'final_location_latitude' => $this->final_location_latitude,
            'final_location_longitude' => $this->final_location_longitude,
            'departure_date' => $this->departure_date,
            'age' => $this->age,
            'total_passenger' => $this->total_passenger,
            'vehicle_class_id' => $this->vehicle_class_id,
            'number_plate' => $this->number_plate,
            'passenger_type' => $this->passenger_type,
        ];
    }
}
