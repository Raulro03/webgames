<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Statistics",
 *     type="object",
 *     title="Statistics",
 *     required={"constitution", "strength", "agility", "intelligence", "charisma"},
 *     @OA\Property(property="constitution", type="integer", example=10),
 *     @OA\Property(property="strength", type="integer", example=8),
 *     @OA\Property(property="agility", type="integer", example=12),
 *     @OA\Property(property="intelligence", type="integer", example=15),
 *     @OA\Property(property="charisma", type="integer", example=14)
 * )
 */
class StatisticsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'constitution' => $this->constitution,
            'strength' => $this->strength,
            'agility' => $this->agility,
            'intelligence' => $this->intelligence,
            'charisma' => $this->charisma,
        ];
    }
}
