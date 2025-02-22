<?php

namespace App\Models;

use App\Models\Scopes\ReleaseDateScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
/**
 * @OA\Schema(
 *     schema="Games",
 *     required={"id", "title", "developer_id", "release_date",},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="The Legend of Zelda: Breath of the Wild"),
 *     @OA\Property(property="description", type="string", example="The Legend of Zelda: Breath of the Wild es un videojuego de acción-aventura de 2017 desarrollado y publicado por Nintendo para la consola Nintendo Switch y Wii U."),
 *     @OA\Property(property="release_date", type="string", format="date", example="2017-03-03"),
 *     @OA\Property(property="price", type="number", format="float", example=59.99),
 *     @OA\Property(property="average_rating", type="number", format="float", example=4.9),
 *     @OA\Property(property="image_url", type="string", example="https://example.com/image.jpg"),
 *     @OA\Property(property="developer_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'release_date',
        'average_rating',
        'price',
        'image_url',
        'developer_id',
    ];

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
        ];
    }

    protected static function booted()
    {
        static::addGlobalScope(new ReleaseDateScope());
    }

    public function developer(): BelongsTo
    {
        return $this->belongsTo(Developer::class);
    }

    public function characters(): BelongsToMany
    {
        return $this->belongsToMany(Character::class, 'character_game')
            ->withPivot('appearance')->withTimestamps();
    }

    public function platforms(): BelongsToMany
    {
        return $this->belongsToMany(Platform::class, 'platform_game')
            ->withPivot('sales')->withTimestamps();
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_game');
    }

}
