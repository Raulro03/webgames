<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreCharacterRequest;
use App\Http\Requests\Api\UpdateCharacterRequest;
use App\Http\Resources\CharacterResource;
use App\Models\Character;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;

class CharacterController extends Controller
{

    /**
     * @OA\Get(
     *     path="/api/characters",
     *     summary="Listar personajes",
     *     description="Devuelve una lista paginada de personajes con sus estadísticas y juegos relacionados.",
     *     operationId="getCharacters",
     *     tags={"Characters"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de personajes",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/Character")),
     *             @OA\Property(property="links", type="object"),
     *             @OA\Property(property="meta", type="object")
     *         )
     *     )
     * )
     */

    public function index()
    {
        return CharacterResource::collection(
            Character::with(['statistics', 'games'])->paginate(10)
        );
    }

    /**
     * @OA\Post(
     *     path="/api/characters",
     *     summary="Crear personaje",
     *     description="Crea un nuevo personaje con estadísticas y juegos asociados.",
     *     operationId="storeCharacter",
     *     tags={"Characters"},
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"name", "statistics"},
     *             @OA\Property(property="name", type="string", example="Geralt"),
     *             @OA\Property(property="age", type="integer", example=100),
     *             @OA\Property(property="description", type="string", example="Un brujo cazador de monstruos."),
     *             @OA\Property(property="statistics", ref="#/components/schemas/Statistics"),
     *             @OA\Property(
     *                 property="games",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"id", "appearance"},
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="appearance", type="string", format="date", example="2024-01-01")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Personaje creado",
     *         @OA\JsonContent(ref="#/components/schemas/Character")
     *     ),
     *     @OA\Response(response=405, description="Logueate")
     * )
     */

    public function store(StoreCharacterRequest $request)
    {
        $character = Character::create($request->only(['name', 'age', 'description']));

        $character->statistics()->create($request->input('statistics', []));

        $games = collect($request->input('games', []))
            ->mapWithKeys(fn($game) => [$game['id'] => ['appearance' => $game['appearance']]]);
        $character->games()->sync($games);

        return new CharacterResource($character->load(['statistics', 'games']));
    }

    /**
     * @OA\Get(
     *     path="/api/characters/{id}",
     *     summary="Mostrar personaje",
     *     description="Obtiene un personaje por ID con sus estadísticas y juegos.",
     *     operationId="showCharacter",
     *     tags={"Characters"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del personaje",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles del personaje",
     *         @OA\JsonContent(ref="#/components/schemas/Character")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Personaje no encontrado"
     *     )
     * )
     */

    public function show(Character $character)
    {
        return new CharacterResource($character->load(['statistics', 'games']));
    }

    /**
     * @OA\Patch(
     *     path="/api/characters/{id}",
     *     summary="Actualizar personaje",
     *     description="Actualiza la información de un personaje, sus estadísticas y juegos.",
     *     operationId="updateCharacter",
     *     tags={"Characters"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del personaje",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Geralt actualizado"),
     *             @OA\Property(property="age", type="integer", example=101),
     *             @OA\Property(property="description", type="string", example="Descripción modificada."),
     *             @OA\Property(property="statistics", ref="#/components/schemas/Statistics"),
     *             @OA\Property(
     *                 property="games",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     required={"id", "appearance"},
     *                     @OA\Property(property="id", type="integer", example=2),
     *                     @OA\Property(property="appearance", type="string", format="date", example="2024-06-01")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Personaje actualizado",
     *         @OA\JsonContent(ref="#/components/schemas/Character")
     *     ),
     *     @OA\Response(response=405, description="Logueate")
     * )
     */

    public function update(UpdateCharacterRequest $request, Character $character)
    {
        $character->update($request->only(['name', 'age', 'description']));

        if ($request->has('statistics')) {
            $character->statistics()->updateOrCreate([], $request->input('statistics'));
        }

        if ($request->has('games')) {
            $games = collect($request->input('games'))
                ->mapWithKeys(fn($game) => [$game['id'] => ['appearance' => $game['appearance']]]);
            $character->games()->sync($games);
        }

        return new CharacterResource($character->load(['statistics', 'games']));
    }

    /**
     * @OA\Delete(
     *     path="/api/characters/{id}",
     *     summary="Eliminar personaje",
     *     description="Elimina un personaje junto con sus estadísticas y relaciones con juegos.",
     *     operationId="deleteCharacter",
     *     tags={"Characters"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del personaje",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Personaje eliminado correctamente"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Personaje no encontrado"
     *     ),
     *     @OA\Response(response=405, description="Logueate")
     * )
     */

    public function destroy(Character $character)
    {

        $character->statistics()->delete();
        $character->games()->detach();
        $character->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);

    }
}

