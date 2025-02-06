<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Character;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Platform;
use App\Models\Statistics;
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

        // Crear 6 plataformas principales
        $platforms = Platform::factory(6)->create();

        // Crear 20 personajes y sus estadísticas (1:1)
        $characters = Character::factory(20)->create()->each(function ($character) {
            Statistics::factory()->create(['character_id' => $character->id]);
        });

        // Crear 6 desarrolladores y asignarles 2 juegos a cada uno
        $developers = Developer::factory(6)->create();

        // Crear 8 categorías
        $categories = Category::factory(8)->create();

        $developers->each(function ($developer) use ($platforms, $characters, $categories) {
            $games = Game::factory(2)->create(['developer_id' => $developer->id]);

            $games->each(function ($game) use ($platforms, $characters, $categories) {
                // Asignar 2 plataformas al juego
                $game->platforms()->attach($platforms->random(2)->pluck('id'));

                // Asignar 2 personajes al juego
                $game->characters()->attach($characters->random(2)->pluck('id'));

                // Asignar 1 o 2 categorías al juego
                $game->categories()->attach($categories->random(rand(1, 2))->pluck('id'));
            });
        });
    }
}
