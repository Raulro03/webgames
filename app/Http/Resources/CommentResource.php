<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Comment */
class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'published_at' => $this->published_at->toISOString(),
            'parent' => new CommentResource($this->whenLoaded('parent')),
            'replies' => CommentResource::collection($this->whenLoaded('replies')),
        ];
    }
}
