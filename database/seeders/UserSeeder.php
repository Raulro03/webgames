<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
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

        if (file_exists(storage_path('app/tokens.txt'))) {
            unlink(storage_path('app/tokens.txt'));
        }

        file_put_contents(storage_path('app/tokens.txt'), "Most Recent Admin Token: $token\n", FILE_APPEND);


        User::factory()->create([
            'name' => 'Normal User',
            'email' => 'normal@example.com',
        ]);

        User::factory(4)->make()->each(function ($user) {
            $user->assignRole('author')->save();
        });
    }
}
