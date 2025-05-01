<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;

/**
 *
 * @OA\Tag(
 *     name="Games",
 *     description="Endpoints para mostrar los juegos"
 * )
 */
class GameController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/games",
     *     summary="Obtener todas los juegos",
     *     tags={"Games"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de juegos paginada",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Games"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Game::query()->paginate(10));

    }
    /**
     * @OA\Get(
     *     path="/api/games/{id}",
     *     summary="Obtener todos los juegos",
     *     tags={"Games"},
     *      @OA\Parameter (
     *          name="id",
     *          in="path",
     *          required=true,
     *          description="ID del juego",
     *     @OA\Schema(type="integer")
     *    ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de juegos paginada",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Games"))
     *     ),
     *     @OA\Response(
     *     response=404,
     *     description="Juego no encontrado",
     *     @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Games"))
     *    )
     * )
     */
    public function show(string $id)
    {
        $game = Game::query()->find($id);
        if (!$game) {
            return response()->json(['error' => 'Game not found'], 404);
        }
        return response()->json($game);
    }
}

