<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TravAccount extends JsonResource
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
            'type' => 'trav-accounts',
            'id' => $this->id,
            'attributes' => [
                'code' => $this->code,
                'balance' => $this->balance,
            ],
        ];
    }
}
