<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Character",
 *     type="object",
 *     title="Character",
 *     required={"id", "name", "statistics"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Geralt of Rivia"),
 *     @OA\Property(property="age", type="integer", example=100),
 *     @OA\Property(property="description", type="string", example="El Dios de todo"),
 *     @OA\Property(property="image_url", type="string", format="uri", example="https://example.com/geralt.png"),
 *     @OA\Property(property="statistics", ref="#/components/schemas/Statistics"),
 *     @OA\Property(
 *         property="games",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Game")
 *     )
 * )
 */
class CharacterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'age' => $this->age,
            'description' => $this->description,
            'image_url' => $this->image_url,
            'statistics' => new StatisticsResource($this->statistics),
            'games' => GameResource::collection($this->games),
            'created_at' => $this->created_at,
        ];
    }
}
