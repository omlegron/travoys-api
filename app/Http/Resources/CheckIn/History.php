<?php

namespace App\Http\Resources\CheckIn;

use Illuminate\Http\Resources\Json\JsonResource;

class History extends JsonResource
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
            'type' => 'check_in_history',
            'attributes' => [
                'rest_area' => [
                    'id' => $this->restArea->id,
                    'name' => $this->restArea->name,
                ],
                'duration' => gmdate("H:i:s", $this->duration),
                'date' => $this->in,
            ],
        ];
    }
}
