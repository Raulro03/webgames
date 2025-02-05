<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('statistics', function (Blueprint $table) {
            $table->id();
            $table->foreignId('character_id')->unique()->constrained()->onDelete('cascade');
            $table->unsignedTinyInteger('constitution')->checkBetween(1, 10);
            $table->unsignedTinyInteger('strength')->checkBetween(1, 10);
            $table->unsignedTinyInteger('agility')->checkBetween(1, 10);
            $table->unsignedTinyInteger('intelligence')->checkBetween(1, 10);
            $table->unsignedTinyInteger('charisma')->checkBetween(1, 10);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('statistics');
    }
};
