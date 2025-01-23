<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('character_game', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Character::class);
            $table->foreignIdFor(\App\Models\Game::class);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('character_game');
    }
};
