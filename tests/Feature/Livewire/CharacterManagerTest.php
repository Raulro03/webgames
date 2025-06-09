<?php

use App\Livewire\CharactersManager;
use App\Models\Character;
use App\Models\Developer;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

it('renders characters manager component', function () {
    Livewire::test(CharactersManager::class)
        ->assertStatus(200);
});

it('creates a new character with image and game appearances', function () {

    adminUser();

    $developer = Developer::factory()->create();
    $game = Game::factory()->create(['developer_id' => $developer->id]);
    $image = UploadedFile::fake()->image('char.png');

    Livewire::test(CharactersManager::class)
        ->set('name', 'Test Character')
        ->set('description', 'Test description')
        ->set('age', 30)
        ->set('image', $image)
        ->set('constitution', 5)
        ->set('strength', 6)
        ->set('agility', 7)
        ->set('intelligence', 8)
        ->set('charisma', 9)
        ->set("gamesAppearance.{$game->id}", '2023-01-01')
        ->call('store')
        ->assertHasNoErrors();

    $character = Character::first();

    expect($character)->not->toBeNull()
        ->and($character->name)->toBe('Test Character')
        ->and(Storage::disk('public')->exists($character->image_url))->toBeTrue()
        ->and($character->games->first()->id)->toBe($game->id)
        ->and($character->games->first()->pivot->appearance)->toBe('2023-01-01');
});

it('edits a character and updates game appearances', function () {

    adminUser();

    $character = Character::factory()->create();
    $developer = Developer::factory()->create();
    $game = Game::factory()->create(['developer_id' => $developer->id]);
    $character->games()->attach($game->id, ['appearance' => '2022-01-01']);

    Livewire::test(CharactersManager::class)
        ->call('edit', $character->id)
        ->set('name', 'Updated Name')
        ->set("gamesAppearance.{$game->id}", '2024-06-01')
        ->set('constitution', 5)
        ->set('strength', 6)
        ->set('agility', 7)
        ->set('intelligence', 8)
        ->set('charisma', 9)
        ->call('update');

    $character->refresh();

    expect($character->name)->toBe('Updated Name')
        ->and($character->games->first()->pivot->appearance)->toBe('2024-06-01');
});

it('deletes a character and its image', function () {

    adminUser();

    $imagePath = UploadedFile::fake()->image('char.png')->store('images/characters', 'public');
    $character = Character::factory()->create(['image_url' => $imagePath]);

    Livewire::test(CharactersManager::class)
        ->call('confirmDelete', $character->id)
        ->call('delete');

    expect(Character::find($character->id))->toBeNull()
        ->and(Storage::disk('public')->exists($imagePath))->toBeFalse();
});

it('shows character detail in modal', function () {

    $character = Character::factory()->create();

    Livewire::test(CharactersManager::class)
        ->call('show', $character->id)
        ->assertSet('ShowModal', true)
        ->assertSet('currentCharacter.id', $character->id);
});

it('resets filters properly', function () {
    Livewire::test(CharactersManager::class)
        ->set('search', 'test')
        ->set('min_age', 10)
        ->set('max_age', 50)
        ->call('resetFilters')
        ->assertSet('search', '')
        ->assertSet('min_age', null)
        ->assertSet('max_age', null);
});

it('toggles game appearance for a character', function () {
    adminUser();

    $game = CreateGameWithDeveloper();

    Livewire::test(CharactersManager::class)
        ->set('gamesAppearance', [])
        ->call('toggleGames', $game->id)
        ->assertSet("gamesAppearance.{$game->id}", fn ($value) => !empty($value))
        ->call('toggleGames', $game->id)
        ->assertDontSee("gamesAppearance.{$game->id}");
});

it('resets flags after deleting a character', function () {
    adminUser();

    $character = Character::factory()->create();

    Livewire::test(CharactersManager::class)
        ->call('confirmDelete', $character->id)
        ->call('delete')
        ->assertSet('DeleteModal', false)
        ->assertSet('confirmingDelete', false)
        ->assertSet('currentCharacter', null);
});

it('generates custom attribute names for validation errors', function () {
    adminUser();

    $game = CreateGameWithDeveloper();

    $component = Livewire::test(CharactersManager::class)
        ->set('gamesAppearance', [$game->id => '2025-01-01'])
        ->instance();

    $attributes = $component->attributes();

    expect($attributes)->toHaveKey("gamesAppearance.{$game->id}");
});
