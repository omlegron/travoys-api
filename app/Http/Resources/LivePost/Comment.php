<?php

namespace App\Http\Resources\LivePost;

use Illuminate\Http\Resources\Json\JsonResource;

class Comment extends JsonResource
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
            'type' => 'comments',
            'id' => $this->id,
            'attributes' => [
                'id' => $this->user->id,
                'avatar' => $this->user->avatar,
                'user' => $this->user->name,
                'comment' => $this->comment,
                'created_at' => $this->created_at,
            ],
        ];
    }
}
