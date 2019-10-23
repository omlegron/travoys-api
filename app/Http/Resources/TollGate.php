<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TollGate extends JsonResource
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
            'type' => 'toll_gates',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'highway_id' => $this->highway_id,
            ],
        ];
    }
}
