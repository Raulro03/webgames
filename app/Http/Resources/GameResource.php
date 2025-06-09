<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="Game",
 *     type="object",
 *     title="Game",
 *     required={"id", "title"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="Elden Ring"),
 *     @OA\Property(property="description", type="string", example="An epic fantasy RPG..."),
 *     @OA\Property(property="release_date", type="string", format="date", example="2022-02-25"),
 *     @OA\Property(property="average_rating", type="number", format="float", example=4.8),
 *     @OA\Property(property="price", type="number", format="float", example=59.99),
 *     @OA\Property(property="image_url", type="string", format="uri", example="https://example.com/image.png"),
 *     @OA\Property(property="developer_id", type="integer", example=10),
 *     @OA\Property(
 *          property="pivot",
 *          type="object",
 *          nullable=true,
 *          @OA\Property(property="appearance", type="string", format="date", example="2023-01-01")
 *      )
 * )
 */
class GameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'release_date' => $this->release_date,
            'average_rating' => $this->average_rating,
            'price' => $this->price,
            'image_url' => $this->image_url,
            'developer_id' => $this->developer_id,
            'pivot' => $this->pivot ? [
                'appearance' => $this->pivot->appearance,
                // otros campos pivot si tienes
            ] : null,
        ];
    }
}
