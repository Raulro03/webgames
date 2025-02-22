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
 *     required={"id", "body", "published_at", "post_id", "user_id", "category_id"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         example=1,
 *         description="ID único del comentario"
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
 *         format="date-time",
 *         example="2025-02-21T13:00:20.000000Z",
 *         description="Fecha y hora en que se publicó el comentario"
 *     ),
 *     @OA\Property(
 *         property="parent",
 *         ref="#/components/schemas/Comment",
 *         nullable=true,
 *         description="Comentario padre si es una respuesta"
 *     ),
 *     @OA\Property(
 *         property="replies",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Comment"),
 *         description="Lista de respuestas a este comentario"
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
