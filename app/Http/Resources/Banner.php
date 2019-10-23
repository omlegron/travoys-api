<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Banner extends JsonResource
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
            'type' => 'banner_get',
            'id' => $this->id,
            'attributes' => [
                'image' => $this->image,
                'link' => $this->link,
                'created_at' => $this->created_at,
                'is_active' => $this->is_active,
            ]
        ];
    }
}
