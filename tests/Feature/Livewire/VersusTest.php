<?php

use App\Livewire\Versus;
use App\Models\Character;
use App\Models\Statistics;
use Livewire\Livewire;


it('renders the versus component', function () {
    Livewire::test(Versus::class)
        ->assertStatus(200)
        ->assertViewIs('livewire.versus');
});

it('loads characters on mount', function () {
    Livewire::test(Versus::class)
        ->assertSet('characters', Character::all());
});

it('allows selecting two characters', function () {
    $characters = CreateCharactersWithStats();

    Livewire::test(Versus::class)
        ->call('selectCharacter', $characters[0]->id)
        ->assertCount('selectedCharacters', 1)
        ->call('selectCharacter', $characters[1]->id)
        ->assertCount('selectedCharacters', 2);
});

it('does not allow selecting more than two characters', function () {
    $characters = CreateCharactersWithStats();

    Livewire::test(Versus::class)
        ->call('selectCharacter', $characters[0]->id)
        ->call('selectCharacter', $characters[1]->id)
        ->call('selectCharacter', $characters[0]->id) // Intento de agregar un tercero
        ->assertCount('selectedCharacters', 2);
});

it('determines the correct winner', function () {
    Character::factory()->create([
        'name' => 'Character 1',
    ]);
    Character::factory()->create([
        'name' => 'Character 2',
    ]);
    Statistics::factory()->create([
        'character_id' => 1,
        'constitution' => 9,
        'strength' => 6,
        'agility' => 7,
        'intelligence' => 8,
        'charisma' => 9,
    ]);
    Statistics::factory()->create([
        'character_id' => 2,
        'constitution' => 3,
        'strength' => 6,
        'agility' => 7,
        'intelligence' => 8,
        'charisma' => 9,
    ]);

    $char1 = Character::with('statistics')->first();
    $char2 = Character::with('statistics')->skip(1)->first();

    Livewire::test(Versus::class)
        ->call('selectCharacter', $char1->id)
        ->call('selectCharacter', $char2->id)
        ->assertSet('winner', $char1);
});

it('returns draw if characters have equal stats', function () {
    $characters = CreateCharactersWithStats();

    Livewire::test(Versus::class)
        ->call('selectCharacter', $characters[0]->id)
        ->call('selectCharacter', $characters[1]->id)
        ->assertSet('winner', 'Empate');
});

it('resets selection and winner', function () {
    $characters = CreateCharactersWithStats();

    Livewire::test(Versus::class)
        ->call('selectCharacter', $characters[0]->id)
        ->call('selectCharacter', $characters[1]->id)
        ->call('resetSelection')
        ->assertSet('selectedCharacters', [])
        ->assertSet('winner', null);
});
