<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @OA\Schema(
 *     schema="Post",
 *     title="Post",
 *     description="Estructura de un post en la API",
 *     required={"id", "title", "body", "status", "published_at"},
 *     @OA\Property(property="id", type="integer", example=1, description="ID del post"),
 *     @OA\Property(property="title", type="string", example="Título del post", description="Título del post"),
 *     @OA\Property(property="body", type="string", example="Contenido del post", description="Cuerpo del post"),
 *     @OA\Property(property="status", type="string", example="published", description="Estado del post"),
 *     @OA\Property(property="published_at", type="string", format="date-time", example="2025-02-22T14:30:00Z", description="Fecha y hora de publicación"),
 *     @OA\Property(
 *         property="comments",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Comment"),
 *         description="Lista de comentarios asociados al post"
 *     )
 * )
 */
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
