<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run(): void
    {

        $this->call([
            UserSeeder::class,
            PlatformsSeeder::class,
            DeveloperSeeder::class,
            CategorySeeder::class,
            CharacterSeeder::class,
            GameSeeder::class,
            ForumCategorySeeder::class,
            PostSeeder::class,
            CommentSeeder::class,
        ]);

    }
}
