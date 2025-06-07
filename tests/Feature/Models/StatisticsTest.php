<?php

use App\Models\Character;
use App\Models\Statistics;

it('allows mass assignment of fillable attributes', function () {
    $character = Character::factory()->create();

    $data = [
        'character_id' => $character->id,
        'constitution' => 10,
        'strength' => 8,
        'agility' => 12,
        'intelligence' => 14,
        'charisma' => 9,
    ];

    $statistics = Statistics::create($data);

    expect($statistics)
        ->character_id->toBe($character->id)
        ->constitution->toBe(10)
        ->strength->toBe(8)
        ->agility->toBe(12)
        ->intelligence->toBe(14)
        ->charisma->toBe(9);
});

// Test de relación belongsTo con Character
it('belongs to a character', function () {
    $character = Character::factory()->create();
    $statistics = Statistics::factory()->create([
        'character_id' => $character->id,
    ]);

    expect($statistics->character)->toBeInstanceOf(Character::class);
    expect($statistics->character->id)->toBe($character->id);
});
