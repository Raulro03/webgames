<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Comment",
 *     title="Comment",
 *     description="Estructura del comentario en la API",
 *     required={"post_id", "user_id", "body", "published_at"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         readOnly=true,
 *         example=1,
 *         description="ID autoincremental del comentario (generado automáticamente)"
 *     ),
 *     @OA\Property(
 *         property="post_id",
 *         type="integer",
 *         example=3,
 *         description="ID del post al que pertenece el comentario"
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         example=5,
 *         description="ID del usuario que escribió el comentario"
 *     ),
 *     @OA\Property(
 *         property="body",
 *         type="string",
 *         example="Este es un comentario de prueba",
 *         description="Contenido del comentario"
 *     ),
 *     @OA\Property(
 *         property="published_at",
 *         type="string",
 *         format="date",
 *         example="2025-04-29",
 *         description="Fecha en la que se publicó el comentario"
 *     ),
 *     @OA\Property(
 *         property="parent_id",
 *         type="integer",
 *         nullable=true,
 *         example=2,
 *         description="ID del comentario padre si este comentario es una respuesta"
 *     )
 * )
 */
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
