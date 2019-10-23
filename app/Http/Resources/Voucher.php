<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Voucher extends JsonResource
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
            'type' => 'vouchers',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'short_description' => $this->short_description,
                'point' => $this->point,
                'amount' => $this->amount,
                'image_url' => $this->image_url,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => $this->when($this->redeemable, [
                'redeemable' => [
                    'data' => [
                        'id' => $this->when($this->redeemable, function () {
                            if (!is_null($this->redeemable)) {
                                return $this->redeemable->id;
                            }
                        }),
                        'type' => 'voucher-codes',
                    ],
                ],
            ]),
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return [
            'included' => $this->when($this->redeemable, [
                new VoucherCode($this->redeemable),
            ]),
        ];
    }
}
