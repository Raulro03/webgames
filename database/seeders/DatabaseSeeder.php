<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Platform;
use App\Models\User;
// use Illuminate\Database\Platform\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create platforms
        $platforms = Platform::factory(5)->create();

        // Create characters
        $characters = Character::factory(20)->create();

        // Create developers and games
        Developer::factory(5)->create()->each(function ($developer) use ($platforms, $characters) {
            $games = Game::factory(rand(2, 3))->create(['developer_id' => $developer->id]);

            $games->each(function ($game) use ($platforms, $characters) {
                // Assign platforms to the game
                $game->platforms()->attach($platforms->random(rand(1, 2))->pluck('id'));

                // Assign characters to the game
                $game->characters()->attach($characters->random(rand(2, 3))->pluck('id'));
            });
        });
    }
}
