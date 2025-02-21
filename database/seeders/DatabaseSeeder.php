<?php

namespace Database\Seeders;

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

        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        $admin->assignRole('admin');

        $token = $admin->createToken('developer-access')->plainTextToken;

        $this->command->info("Admin Token: $token");

        file_put_contents(storage_path('app/tokens.txt'), "Admin Token: $token");


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
