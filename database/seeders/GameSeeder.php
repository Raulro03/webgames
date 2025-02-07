<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Character;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Platform;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $developers = Developer::all();
        $platforms = Platform::all();
        $characters = Character::all();
        $categories = Category::all();

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
