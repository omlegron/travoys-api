<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Place extends JsonResource
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
            'type' => 'places',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'address' => $this->address,
                'photo_url' => $this->photo_url,
                'category_id' => $this->category_id,
                'category_name' => $this->category->name,
                'longitude' => $this->longitude,
                'latitude' => $this->latitude,
                'distance' => $this->when(!is_null($this->distance), $this->distance),
            ],
        ];
    }
}
