<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCommentRequest;
use App\Http\Requests\Api\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;

/**
 * @OA\Tag(
 *     name="Comments",
 *     description="Endpoints para gestionar los comentarios"
 * )
 */
class CommentController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/comments",
     *     summary="Obtener todos los comentarios paginados",
     *     tags={"Comments"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de comentarios paginados",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Comment")),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */
    public function index()
    {
        return CommentResource::collection(Comment::query()->paginate(10));
    }

    /**
     * @OA\Post(
     *     path="/api/comments",
     *     summary="Crear un nuevo comentario",
     *     tags={"Comments"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"post_id", "body"},
     *             @OA\Property(property="post_id", type="integer", example=1),
     *             @OA\Property(property="body", type="string", example="Este es un comentario de prueba"),
     *             @OA\Property(property="parent_id", type="integer", nullable=true, example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Comentario creado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Comment")
     *     ),
     *     @OA\Response(response=401, description="No autenticado"),
     *     @OA\Response(response=422, description="Error de validación")
     * )
     */
    public function store(StoreCommentRequest $request)
    {
        $data = array_merge($request->validated(), [
            'user_id' => auth()->id(),
            'published_at' => now()
        ]);

        $comment = Comment::create($data);

        return new CommentResource($comment);
    }

    /**
     * @OA\Get(
     *     path="/api/comments/{id}",
     *     summary="Obtener un comentario específico con sus respuestas",
     *     tags={"Comments"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del comentario",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comentario obtenido con éxito",
     *         @OA\JsonContent(ref="#/components/schemas/Comment")
     *     ),
     *     @OA\Response(response=404, description="Comentario no encontrado")
     * )
     */
    public function show(Comment $comment)
    {
        return new CommentResource(Comment::with('parent', 'replies')->find($comment->id));
    }

    /**
     * @OA\Put(
     *     path="/api/comments/{id}",
     *     summary="Actualizar un comentario",
     *     tags={"Comments"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del comentario a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"body"},
     *            @OA\Property(property="user_id", type="integer", example=5, description="ID del usuario que edita el comentario"),
     *            @OA\Property(property="body", type="string", example="Este es un comentario actualizado", description="Nuevo contenido del comentario"),
     *            @OA\Property(property="published_at", type="string", format="date", example="2025-04-29", description="Fecha de publicación"),
     *            @OA\Property(property="post_id", type="integer", example=3, description="ID del post donde esta el comentario")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Comentario actualizado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Comment")
     *     ),
     *     @OA\Response(response=401, description="No autenticado"),
     *     @OA\Response(response=403, description="No autorizado para actualizar este comentario"),
     *     @OA\Response(response=404, description="Comentario no encontrado")
     * )
     */
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        $comment->update($request->validated());

        return new CommentResource($comment);
    }

    /**
     * @OA\Delete(
     *     path="/api/comments/{id}",
     *     summary="Eliminar un comentario",
     *     tags={"Comments"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del comentario a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(response=204, description="Comentario eliminado correctamente"),
     *     @OA\Response(response=401, description="No autenticado"),
     *     @OA\Response(response=403, description="No autorizado para eliminar este comentario"),
     *     @OA\Response(response=404, description="Comentario no encontrado")
     * )
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json(null, 204);
    }
}
