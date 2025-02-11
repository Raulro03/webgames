<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('character_game', function (Blueprint $table) {
            $table->date('appearance')->after('game_id');
        });
    }

    public function down(): void
    {
        Schema::table('character_game', function (Blueprint $table) {
            $table->dropColumn('appearance');
        });
    }
};
