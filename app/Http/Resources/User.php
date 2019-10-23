<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
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
            'type' => 'users',
            'id' => $this->id,
            'attributes' => [
                'avatar' => $this->avatar,
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'saldo' => $this->saldo,
                'golongan' => $this->golongan,
                'rf_idkey' => $this->rf_idkey,
                'golongan_kendaraan' => $this->golongan_kendaraan,
                'plat_no_kendaraan' => $this->plat_no_kendaraan,
                $this->mergeWhen($this->auth, [
                    'device_id' => $this->device_id,
                    'fcm_device_token' => $this->fcm_device_token,
                    'is_verified' => $this->is_verified,
                    'is_satgas' => $this->is_satgas,
                    'is_admin' => $this->is_admin,
                    'auth' => $this->auth,
                ]),
            ],
            'relationships' => $this->when($this->is_satgas, [
                'satgas' => [
                    'data' => [
                        'id' => $this->when($this->is_satgas, function () {
                            return $this->satgasAt->first()->id;
                        }),
                        'type' => 'rest-areas',
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
            'included' => $this->when($this->is_satgas, [
                new RestArea($this->satgasAt->first()),
            ]),
        ];
    }
}
