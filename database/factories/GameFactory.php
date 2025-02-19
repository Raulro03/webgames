<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->text(200),
            'release_date' => Carbon::now()->subYears(rand(0, 10)),
            'average_rating' => $this->faker->randomFloat(2, 0, 9.99),
            'price' => $this->faker->randomNumber(),
            'image_url' => 'images/games/' . $this->faker->randomElement([
                    'ds1.jpg',
                    'uncharted.jpg',
                    'wars.jpg',
                ]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
