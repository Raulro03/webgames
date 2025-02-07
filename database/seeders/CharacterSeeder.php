<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Statistics;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CharacterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Character::factory(20)->create()->each(function ($character) {
            Statistics::factory()->create(['character_id' => $character->id]);
        });
    }
}
