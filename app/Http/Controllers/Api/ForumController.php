<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePostRequest;
use App\Http\Requests\Api\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Symfony\Component\HttpFoundation\Response;

/**
 * @OA\Tag(
 *     name="Posts",
 *     description="Endpoints para la gestión de posts en el foro"
 * )
 */
class ForumController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/posts",
     *     summary="Obtener todos los posts paginados",
     *     tags={"Posts"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de posts paginados",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Post"))
     *     )
     * )
     */
    public function index()
    {
        return PostResource::collection(Post::with('comments')->paginate(9));
    }

    /**
     * @OA\Post(
     *     path="/api/posts",
     *     summary="Crear un nuevo post",
     *     tags={"Posts"},
     *     security={{ "bearerAuth": {} }},
     *
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"title", "body", "published_at", "category_id"},
     *              @OA\Property(
     *                  property="title",
     *                  type="string",
     *                  example="Mi opinión sobre el nuevo videojuego"
     *              ),
     *              @OA\Property(
     *                  property="body",
     *                  type="string",
     *                  example="Este juego es increíble por muchas razones..."
     *              ),
     *              @OA\Property(
     *                  property="published_at",
     *                  type="string",
     *                  format="date-time",
     *                  example="2025-06-08"
     *              ),
     *              @OA\Property(
     *                  property="category_id",
     *                  type="integer",
     *                  example=3
     *              )
     *          )
     *      ),
     *
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Post creado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     )
     * )
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data = array_merge($data, ['user_id' => auth()->id()]);
        $post = Post::create($data);

        return new PostResource($post);
    }

    /**
     * @OA\Get(
     *     path="/api/posts/{id}",
     *     summary="Obtener un post por su ID",
     *     tags={"Posts"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del post",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del post",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post no encontrado"
     *     )
     * )
     */
    public function show(Post $post)
    {
        return new PostResource(Post::with('comments')->findOrFail($post->id));
    }

    /**
     * @OA\Patch(
     *     path="/api/posts/{id}",
     *     summary="Actualizar un post existente",
     *     tags={"Posts"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del post a actualizar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"title", "body", "published_at", "category_id"},
     *              @OA\Property(
     *                  property="title",
     *                  type="string",
     *                  example="Mi opinión sobre el nuevo videojuego actualziado"
     *              ),
     *              @OA\Property(
     *                  property="body",
     *                  type="string",
     *                  example="Este juego es increíble por muchas razones... actualizado"
     *              ),
     *              @OA\Property(
     *                  property="published_at",
     *                  type="string",
     *                  format="date-time",
     *                  example="2024-06-08"
     *              ),
     *              @OA\Property(
     *                  property="category_id",
     *                  type="integer",
     *                  example=3
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Post actualizado correctamente",
     *         @OA\JsonContent(ref="#/components/schemas/Post")
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post no encontrado"
     *     )
     * )
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());

        return new PostResource($post);
    }

    /**
     * @OA\Delete(
     *     path="/api/posts/{id}",
     *     summary="Eliminar un post por su ID",
     *     tags={"Posts"},
     *     security={{ "bearerAuth": {} }},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del post a eliminar",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Post eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autenticado"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Post no encontrado"
     *     ),
     *     @OA\Response(response=405, description="Logueate")
     * )
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
