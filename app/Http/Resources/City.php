<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class City extends JsonResource
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
            'type' => 'cities',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'photo_url' => $this->photo_url,
                'distance' => $this->when(!is_null($this->distance), $this->distance),
            ],
        ];
    }
}
