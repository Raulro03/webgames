<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('category_game', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Category::class);
            $table->foreignIdFor(\App\Models\Game::class);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_game');
    }
};
