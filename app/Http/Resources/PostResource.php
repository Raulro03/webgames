<?php

namespace App\Http\Resources;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'status' => $this->status,
            'published_at' => $this->published_at,
            'comments' => CommentResource::collection($this->whenLoaded('comments')),

        ];
    }
}
