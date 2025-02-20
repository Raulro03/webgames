<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Character;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Platform;
use App\Models\Statistics;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RoleSeeder::class,
        ]);

        $user = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        $user->assignRole('admin');

        $token = $user->createToken('developer-access')->plainTextToken;

        echo "{$token}";

        User::factory()->create([
            'name' => 'Normal User',
            'email' => 'normal@example.com',
        ]);

        User::factory(4)->make()->each(function ($user) {
            $user->assignRole('author')->save();
        });


        $this->call([
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
