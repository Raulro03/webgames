<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Platform extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'release_date',
        'price',
        'average_rating',
    ];

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
        ];
    }

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'platform_game');
    }
}
