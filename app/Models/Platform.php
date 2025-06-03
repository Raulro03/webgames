<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
/**
 * @OA\Schema(
 *     schema="Platform",
 *     required={"id", "name", "release_date"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="PlayStation 5", maxLength=50 ),
 *     @OA\Property(property="description", type="string", example="La PlayStation 5 es una consola de videojuegos de sobremesa desarrollada por Sony Interactive Entertainment.", maxLength=100 ),
 *     @OA\Property(property="release_date", type="string", format="date", example="2020-11-12"),
 *     @OA\Property(property="price", type="int", example=4990),
 *     @OA\Property(property="average_rating", type="number", format="float" , maximum=9.99, minimum=0 , example=4.50),
 *     @OA\Property(property="image_url", type="string", example="images/platforms/nintendo.png"),
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
    public function scopeFilter($query, $filters)
    {
        return $query
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->when($filters['min_price'] ?? null, function ($query, $min) {
                $query->where('price', '>=', $min * 100);
            })
            ->when($filters['max_price'] ?? null, function ($query, $max) {
                $query->where('price', '<=', $max * 100);
            })
            ->when($filters['min_rating'] ?? null, function ($query, $min) {
                $query->where('average_rating', '>=', $min);
            })
            ->when($filters['max_rating'] ?? null, function ($query, $max) {
                $query->where('average_rating', '<=', $max);
            })
            ->when($filters['release_from'] ?? null, function ($query, $from) {
                $query->whereDate('release_date', '>=', $from);
            })
            ->when($filters['release_to'] ?? null, function ($query, $to) {
                $query->whereDate('release_date', '<=', $to);
            });
    }

}
