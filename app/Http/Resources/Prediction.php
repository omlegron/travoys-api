<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Prediction extends JsonResource
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
            'type' => 'prediction_get',
            'attributes' => [
                $request->type => $this->datetime,
                'rekapitulasi_total_pemudik' => (int) $this->total_travelers,
                'rekapitulasi_total_kendaraan' => $this->total_vehicles,
            ],
        ];
    }
}
