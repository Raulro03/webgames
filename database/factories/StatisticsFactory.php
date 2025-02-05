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
            'character_id' => $this->faker->randomNumber(),
            'constitution' => $this->faker->randomNumber(),
            'strength' => $this->faker->randomNumber(),
            'agility' => $this->faker->randomNumber(),
            'intelligence' => $this->faker->randomNumber(),
            'charisma' => $this->faker->randomNumber(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
