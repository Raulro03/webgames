<?php

namespace Database\Seeders;

use App\Models\Platform;
use Illuminate\Database\Seeder;

class PlatformsSeeder extends Seeder
{
    public function run(): void
    {
        Platform::factory(6)->create();
    }
}
