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
            'release_date' => Carbon::now()->subYears(rand(0, 10)),
            'price' => $this->faker->randomNumber(),
            'average_rating' => $this->faker->randomFloat(2, 0, 9.99),
            'image_url' => 'storage/images/platforms/' . $this->faker->randomElement([
                    'nintendo.png',
                    'ps4.png',
                    'xbox.png',
                ]),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
