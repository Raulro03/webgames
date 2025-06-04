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
        return $this->belongsToMany(Game::class, 'character_game')
            ->withPivot('appearance')->withTimestamps();
    }

    public function statistics(): HasOne
    {
        return $this->hasOne(Statistics::class);
    }

    public function scopeFilterCharacter($query, $filters)
    {
        $query
            ->when($filters['search'] ?? null, fn($q, $search) => //Funciones en arrow para importar variables de fuera usar uses mas comodo para scopes
            $q->where('name', 'like', '%' . $search . '%'))

            ->when($filters['min_age'] ?? null, fn($q, $minAge) =>
            $q->where('age', '>=', $minAge))

            ->when($filters['max_age'] ?? null, fn($q, $maxAge) =>
            $q->where('age', '<=', $maxAge))

            ->when(
                $this->hasStatFilters($filters),
                fn($q) => $q->whereHas('statistics', function ($statQuery) use ($filters) {
                    $statQuery
                        ->when($filters['min_constitution'] ?? null, fn($q, $val) => $q->where('constitution', '>=', $val))
                        ->when($filters['min_strength'] ?? null, fn($q, $val) => $q->where('strength', '>=', $val))
                        ->when($filters['min_agility'] ?? null, fn($q, $val) => $q->where('agility', '>=', $val))
                        ->when($filters['min_intelligence'] ?? null, fn($q, $val) => $q->where('intelligence', '>=', $val))
                        ->when($filters['min_charisma'] ?? null, fn($q, $val) => $q->where('charisma', '>=', $val));
                })
            );
    }
    private function hasStatFilters($filters): bool
    {
        return collect([
            'min_constitution', 'min_strength', 'min_agility', 'min_intelligence', 'min_charisma'
        ])->contains(fn($key) => !empty($filters[$key]));
    }

}
