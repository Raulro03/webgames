<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
/**
 * @OA\Schema(
 *     schema="Platform",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="PlayStation 5"),
 *     @OA\Property(property="description", type="string", example="La PlayStation 5 es una consola de videojuegos de sobremesa desarrollada por Sony Interactive Entertainment. Anunciada en 2019 como la sucesora de la PlayStation 4, se lanzó el 12 de noviembre de 2020 en Australia, Japón, Nueva Zelanda, América del Norte y Corea del Sur, y el 19 de noviembre de 2020 en el resto del mundo."),
 *     @OA\Property(property="release_date", type="string", format="date", example="2020-11-12"),
 *     @OA\Property(property="price", type="number", format="float", example=499.99),
 *     @OA\Property(property="average_rating", type="number", format="float", example=4.5),
 *     @OA\Property(property="image_url", type="string", example="https://example.com/image.jpg"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Platform extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'release_date',
        'price',
        'average_rating',
        'image_url',
    ];

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
        ];
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'platform_game')
            ->withPivot('sales')->withTimestamps();
    }
}
