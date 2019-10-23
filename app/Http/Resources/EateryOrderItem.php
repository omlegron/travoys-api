<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EateryOrderItem extends JsonResource
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
            'code'      => $this->code,
            'user'   => $this->user,
            'eatery_id' => $this->eatery_id,
            'status'    => $this->status,
        ];
    }
}
