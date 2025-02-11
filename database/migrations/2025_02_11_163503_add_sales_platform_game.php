<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('platform_game', function (Blueprint $table) {
            $table->integer('sales')->after('game_id');
        });
    }

    public function down(): void
    {
        Schema::table('platform_game', function (Blueprint $table) {
            $table->dropColumn('sales');
        });
    }
};
