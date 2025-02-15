<?php

namespace Database\Seeders;

use App\Models\ForumCategory;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::factory(50)->state(function () {
            return [
                'user_id' => User::inRandomOrder()->first()->id,
                'category_id' => ForumCategory::inRandomOrder()->first()->id,
            ];
        })->create();
    }
}
