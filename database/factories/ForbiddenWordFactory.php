<?php

namespace Database\Factories;

use App\Models\ForbiddenWord;
use Illuminate\Database\Eloquent\Factories\Factory;

class ForbiddenWordFactory extends Factory
{
    protected $model = ForbiddenWord::class;

    public function definition(): array
    {
        return [
            'word' => $this->faker->unique()->word(),
        ];
    }
}
