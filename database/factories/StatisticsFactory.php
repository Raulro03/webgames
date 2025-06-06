<?php

namespace Database\Factories;

use App\Models\Statistics;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class StatisticsFactory extends Factory
{
    protected $model = Statistics::class;

    public function definition(): array
    {
        return [
            'character_id' => $this->faker->unique()->randomNumber(),
            'constitution' => $this->faker->numberBetween(1, 10),
            'strength' => $this->faker->numberBetween(1, 10),
            'agility' => $this->faker->numberBetween(1, 10),
            'intelligence' => $this->faker->numberBetween(1, 10),
            'charisma' => $this->faker->numberBetween(1, 10),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
