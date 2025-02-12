<?php

namespace Database\Factories;

use App\Models\ForumCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ForumCategoryFactory extends Factory
{
    protected $model = ForumCategory::class;

    public function definition(): array
    {
        return [
            'category_type' => $this->faker->randomElement(['game', 'platform', 'character', 'general']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
