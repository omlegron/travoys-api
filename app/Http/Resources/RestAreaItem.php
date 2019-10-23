<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RestAreaItem extends JsonResource
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
            'image' => $this->image,
            'name' => $this->name,
            'route' => $this->route,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'highway_id' => $this->highway_id,
            'distance' => $this->when(!is_null($this->distance), $this->distance),
            'parking_status' => $this->when($this->parkingSlot, function () {
                $parking_slot = $this->parkingSlot;

                $ratio = $parking_slot->used_slots / $parking_slot->slots;

                if ($ratio <= 2 / 5) {
                    return "Kosong";
                } else if ($ratio > 2 / 5 && $ratio <= 4.5 / 5) {
                    return "Ramai";
                } else {
                    return "Penuh";
                }
            }),
            'capacity' => $this->when(
                $this->parkingSlot,
                function () {
                    return $this->parkingSlot->slots;
                }
            ),
            $this->mergeWhen(
                $this->fuel,
                function () {
                    return [
                        'fuel_status' => [
                            'pertalite' => $this->fuel->pertalite,
                            'pertamax' => $this->fuel->pertamax,
                            'pertamax_plus' => $this->fuel->pertamax_plus,
                            'dexlite' => $this->fuel->dexlite,
                        ]
                    ];
                }
            )
        ];
    }
}
