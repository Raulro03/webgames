<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description', 200)->nullable();
            $table->date('release_date');
            $table->decimal('average_rating', 3,2)->nullable();
            $table->integer('price')->nullable();
            $table->string('image_url')->nullable();
            $table->foreignIdFor(\App\Models\Developer::class);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('games');
    }
};
