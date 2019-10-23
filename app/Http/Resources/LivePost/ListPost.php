<?php

namespace App\Http\Resources\LivePost;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\LivePost\Comment as CommentResource;

class ListPost extends JsonResource
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
            'type' => 'live_post_get',
            'id' => $this->id,
            'attributes' => [
                'user' => [
                    'id' => $this->user->id,
                    'avatar' => $this->user->avatar,
                    'name' => $this->user->name,
                ],
                'image' => $this->image,
                'longitude' => $this->longitude,
                'latitude' => $this->latitude,
                'nomor_km' => $this->nomor_km,
                'location' => $this->location,
                'post' => $this->post,
                'created_at' => $this->created_at,
                'comment' => CommentResource::collection($this->comment->take(1)),
            ],
        ];
    }
}
