<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/*
 * Used in:
 * - App\Http\Resources\User.php
 */
class RestArea extends JsonResource
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
            'type' => 'rest-areas',
            'id' => $this->id,
            'attributes' => [
                'image' => $this->image,
                'name' => $this->name,
                'route' => $this->route,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'highway_id' => $this->highway_id,
                'distance' => $this->when(!is_null($this->distance), $this->distance),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
        ];
    }
}
