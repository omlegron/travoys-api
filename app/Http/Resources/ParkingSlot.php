<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ParkingSlot extends JsonResource
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
            'type' => 'parking_slot_details',
            'id' => $this->id,
            'attributes' => [
                'used_slots' => $this->used_slots,
                'free_slots' => $this->slots - $this->used_slots,
                'total_slots' => $this->slots,
            ]
        ];
    }
}
