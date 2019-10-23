<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VoucherCode extends JsonResource
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
            'type' => 'voucher-codes',
            'id' => $this->id,
            'attributes' => [
                'voucher_id' => $this->voucher_id,
                'redeemer_id' => $this->redeemer_id,
                'code' => $this->code,
                'expired_at' => $this->expired_at,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
        ];
    }
}
