<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Reply extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'body' => $this->body,
            'user' => $this->user->name,
            'user_id' => $this->user_id,
            'like_count' => $this->likes->count(),
            'liked_already' => $this->likes()->where('user_id', auth()->id())->count() === 1,
            'created_at' => $this->created_at->diffForHumans()
        ];
    }
}
