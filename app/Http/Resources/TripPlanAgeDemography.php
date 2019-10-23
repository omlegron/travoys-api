<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TripPlanAgeDemography extends JsonResource
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
            'type' => 'age-demography',
            'attributes' => [
                'age' => $this['age'],
                'count' => $this['count'],
            ],
        ];
    }
}
