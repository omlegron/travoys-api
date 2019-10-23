<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestAreaPlace extends JsonResource
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
            'type' => 'rest-area-places',
            'id' => $this->id,
            'attributes' => [
                'image' => $this->image,
                'name' => $this->name,
                'latitude' => $this->latitude,
                'longitude' => $this->longitude,
                'type' => $this->type->name,
            ],
        ];
    }
}
