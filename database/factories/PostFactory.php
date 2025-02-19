<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'body' => $this->faker->paragraph(),
            'published_at' => $published_at = $this->faker->dateTimeBetween('-1 year', '+1 year'),
            'status' => $published_at > Carbon::now() ? 'not_published' : ($published_at > Carbon::now()->subYear() ? 'published' : 'archived'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
