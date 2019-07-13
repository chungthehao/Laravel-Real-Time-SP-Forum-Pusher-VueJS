<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Reply as ReplyResource;

class Question extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request); // Laravel để sẵn 1 mẫu gợi ý

        $replies = $this->replies()->latest()->get();
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'path' => $this->path, // accessor (ở Question model)
            'body' => $this->body,
            'created_at' => $this->created_at->diffForHumans(), // Vì $this->created_at trả về instance của Carbon
            'user' => $this->user->name,
            'user_id' => $this->user->id,
            'replies' => ReplyResource::collection($replies),
            'reply_count' => $replies->count(),
        ];
    }
}
