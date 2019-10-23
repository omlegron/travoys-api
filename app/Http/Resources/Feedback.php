<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Feedback extends JsonResource
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
            'type' => 'feedback',
            'id' => $this->id,
            'attributes' => [
                'category_id' => $this->category_id,
                'category_name' => $this->when($this->category_id, function () {
                    return $this->category->name;
                }),
                'feedback' => $this->feedback,
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ],
            'relationships' => [
                'author' => [
                    'data' => [
                        'id' => $this->user_id,
                        'type' => 'users',
                    ],
                ],
                'category' => $this->when($this->category_id, [
                    'data' => [
                        'id' => $this->category_id,
                        'type' => 'feedback-categories',
                    ],
                ]),
            ],
        ];
    }
}
