<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Platform;

/**
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="Token",
 *     description="Token personal generado por Sanctum"
 * )
 * @OA\Info(
 *      version="1.0.0",
 *      title="WebGames API",
 *      description="Documentación de la API para la gestión de WebGames",
 *      @OA\Contact(
 *          email="soporte@webgames.com"
 *      )
 * )
 *
 * @OA\Tag(
 *     name="Platforms",
 *     description="Endpoints para la gestión de plataformas"
 * )
 */
class PlatformController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/platforms",
     *     summary="Obtener todas las plataformas",
     *     tags={"Platforms"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de plataformas paginada",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Platform"))
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Platform::query()->paginate(10));

    }
    /**
     * @OA\Get(
     *     path="/api/platforms/{id}",
     *     summary="Obtener una plataforma específica",
     *     tags={"Platforms"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de la plataforma",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalles de la plataforma",
     *         @OA\JsonContent(ref="#/components/schemas/Platform")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Plataforma no encontrada"
     *     )
     * )
     */
    public function show(string $id)
    {

        $platform = Platform::query()->find($id);
        if (!$platform) {
            return response()->json(['error' => 'Platform not found'], 404);
        }
        return response()->json($platform);
    }
}
