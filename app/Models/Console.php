<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Console extends Model
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
}
