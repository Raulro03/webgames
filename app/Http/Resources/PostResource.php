<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
/**
 * @OA\Schema(
 *     schema="Post",
 *     description="Estructura de un post en la API",
 *     required={"user_id", "category_id", "title", "body", "status", "published_at"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         readOnly=true,
 *         example=1,
 *         description="ID autoincremental del post (generado automáticamente)"
 *     ),
 *     @OA\Property(property="user_id", type="integer", example=5, description="ID del usuario que creó el post"),
 *     @OA\Property(property="category_id", type="integer", example=2, description="ID de la categoría del foro"),
 *     @OA\Property(property="title", type="string", example="Título del post", description="Título del post"),
 *     @OA\Property(property="body", type="string", example="Contenido detallado del post", description="Cuerpo del post"),
 *     @OA\Property(property="status", type="string", example="published", description="Estado del post"),
 *     @OA\Property(property="published_at", type="string", format="date", example="2025-04-29", description="Fecha de publicación"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-04-29", description="Fecha de creación"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-04-29", description="Fecha de última modificación"),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true, example="null", description="Fecha de borrado lógico (soft delete)"),
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
