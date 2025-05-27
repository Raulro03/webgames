<?php

namespace Database\Seeders;

use App\Models\ForbiddenWord;
use Illuminate\Database\Seeder;

class ForbiddenWordSeeder extends Seeder
{
    public function run(): void
    {
        $palabras = [
            'maldición',
            'insulto',
            'ofensivo',
            'matar',
            'drogas',
        ];

        foreach ($palabras as $palabra) {
            ForbiddenWord::create([
                'word' => $palabra,
                'status' => 'accept',
            ]);
        }

        ForbiddenWord::factory()->count(5)->create([
            'status' => 'pending',
        ]);
    }
}
