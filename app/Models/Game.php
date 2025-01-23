<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'release_date',
        'average_rating',
    ];

    protected function casts(): array
    {
        return [
            'release_date' => 'date',
        ];
    }

    public function developer()
    {
        return $this->belongsTo(Developer::class);
    }

    public function characters()
    {
        return $this->belongsToMany(Character::class);
    }

    public function platforms()
    {
        return $this->belongsToMany(Platform::class);
    }

}
