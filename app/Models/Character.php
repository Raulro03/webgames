<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Character extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_url',
    ];

    public function games(): BelongsToMany
    {
        return $this->belongsToMany(Game::class, 'character_game');
    }

    public function statistics(): HasOne
    {
        return $this->hasOne(Statistics::class);
    }
}
