<?php

namespace Database\Factories;

use App\Models\Character;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class CharacterFactory extends Factory
{
    protected $model = Character::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->text(100),
            'age' => $this->faker->numberBetween(1, 100),
            'image_url' => 'images/characters/' . $this->faker->randomElement([
                    'darth.jpg',
                    'leon.png',
                    'mario.png',
                    ]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
