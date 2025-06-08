<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Http\Resources\GameResource;

/**
 *
 * @OA\Tag(
 *     name="Game",
 *     description="Endpoints para mostrar los juegos"
 * )
 */
class GameController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/games",
     *     summary="Obtener todas los juegos",
     *     tags={"Game"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de juegos paginada",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Game"))
     *     )
     * )
     */
    public function index()
    {
        return GameResource::collection(
            Game::paginate(10)
        );

    }
    /**
     * @OA\Get(
     *     path="/api/games/{id}",
     *     summary="Obtener juego por ID",
     *     tags={"Game"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del juego",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del juego",
     *         @OA\JsonContent(ref="#/components/schemas/Game")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Juego no encontrado",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="error", type="string", example="Game not found")
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        $game = Game::find($id);

        if (!$game) {
            return response()->json(['error' => 'Game not found'], 404);
        }

        return new GameResource($game);
    }
}

