<?php

namespace Database\Factories;

use App\Models\Console;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ConsoleFactory extends Factory
{
    protected $model = Console::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(),
            'release_date' => Carbon::now(),
            'price' => $this->faker->randomNumber(),
            'average_rating' => $this->faker->randomFloat(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
