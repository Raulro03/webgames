<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\ForumCategory;
use App\Models\Game;
use App\Models\Platform;
use Illuminate\Database\Seeder;

class ForumCategorySeeder extends Seeder
{
    public function run(): void
    {
        ForumCategory::factory(5)->create()->each(function ($category) {
            if ($category->type === 'game') {
                $category->related_id = Game::inRandomOrder()->first()->id ?? null;
            } elseif ($category->type === 'platform') {
                $category->related_id = Platform::inRandomOrder()->first()->id ?? null;
            } elseif ($category->type === 'character') {
                $category->related_id = Character::inRandomOrder()->first()->id ?? null;
            } else {
                $category->related_id = null;
            }
            $category->save();
        });
    }
}
