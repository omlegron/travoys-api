<?php

namespace App\Http\Resources\CheckIn;

use Illuminate\Http\Resources\Json\JsonResource;

class Details extends JsonResource
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
            'type' => 'check_in_details',
            'attributes' => [
                'id' => $this->id,
                'user' => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                ],
                'rest_area' => [
                    'id' => $this->restArea->id,
                    'name' => $this->restArea->name,
                ],
                'in' => $this->in,
                'out' => $this->out
            ],
        ];
    }
}
