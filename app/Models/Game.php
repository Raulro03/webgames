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
}
