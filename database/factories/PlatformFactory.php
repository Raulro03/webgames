<?php

namespace Database\Factories;

use App\Models\Platform;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PlatformFactory extends Factory
{
    protected $model = Platform::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(100),
            'release_date' => Carbon::now(),
            'price' => $this->faker->randomNumber(),
            'average_rating' => $this->faker->randomFloat(2, 0, 9.99),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
