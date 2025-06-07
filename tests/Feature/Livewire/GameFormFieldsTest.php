<?php

use App\Livewire\GameFormFields;
use App\Models\Developer;
use App\Models\Game;
use App\Models\Platform;
use App\Models\Character;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;


it('can render the component', function () {
    Livewire::test(GameFormFields::class)
        ->assertStatus(200);
});

it('creates a game with platforms and characters', function () {

    adminUser();

    $developer = Developer::factory()->create();
    $platform = Platform::factory()->create();
    $character = Character::factory()->create();

    $image = UploadedFile::fake()->image('game.jpg');

    Livewire::test(GameFormFields::class)
        ->set('title', 'Test GameSS')
        ->set('description', 'Test description')
        ->set('price', 1999)
        ->set('release_date', '2025-06-06')
        ->set('average_rating', 4.5)
        ->set('developer_id', $developer->id)
        ->set('image', $image)
        ->call('togglePlatform', $platform->id)
        ->set("platformSales.$platform->id", 2000)
        ->call('toggleCharacter', $character->id)
        ->set("characterAppearance.$character->id", '2025-06-01')
        ->call('save')
        ->assertRedirect(route('games'));

    $game = Game::where('title', 'Test GameSS')->first();
    expect($game)->not->toBeNull();
    expect($game->platforms()->first()->pivot->sales)->toBe(2000);

    $appearance = $game->characters()->first()->pivot->appearance;
    expect(Carbon::parse($appearance)->toDateString())->toBe('2025-06-01');

    Storage::disk('public')->assertExists($game->image_url);
});

it('updates an existing game', function () {
    adminUser();

    $developer = Developer::factory()->create();
    $game = Game::factory()->create(['developer_id' => $developer->id]);
    $platform = Platform::factory()->create();
    $character = Character::factory()->create();

    $game->platforms()->attach($platform->id, ['sales' => 1000]);
    $game->characters()->attach($character->id, ['appearance' => '2025-01-01']);

    $image = UploadedFile::fake()->image('updated.jpg');

    Livewire::test(GameFormFields::class, ['game' => $game])
        ->set('title', 'Updated Game')
        ->set('image', $image)
        ->set("platformSales.$platform->id", 3000)
        ->set("characterAppearance.$character->id", '2025-02-01')
        ->call('save')
        ->assertRedirect(route('games'));

    $game->refresh();
    expect($game->title)->toBe('Updated Game');
    expect($game->platforms()->first()->pivot->sales)->toBe(3000);
    $appearance = $game->characters()->first()->pivot->appearance;
    expect(Carbon::parse($appearance)->toDateString())->toBe('2025-02-01');
    Storage::disk('public')->assertExists($game->image_url);
});

it('validates image upload', function () {
    $invalidFile = UploadedFile::fake()->create('file.pdf', 100, 'application/pdf');

    Livewire::test(GameFormFields::class)
        ->set('image', $invalidFile)
        ->assertHasErrors(['image' => 'image']);
});

it('removes platform or character when toggled twice', function () {
    adminUser();

    $platform = Platform::factory()->create();
    $character = Character::factory()->create();

    $test = Livewire::test(GameFormFields::class);

    $test->call('togglePlatform', $platform->id);
    expect($test->get('platformSales'))->toHaveKey($platform->id);

    $test->call('togglePlatform', $platform->id);
    expect($test->get('platformSales'))->not->toHaveKey($platform->id);

    $test->call('toggleCharacter', $character->id);
    expect($test->get('characterAppearance'))->toHaveKey($character->id);

    $test->call('toggleCharacter', $character->id);
    expect($test->get('characterAppearance'))->not->toHaveKey($character->id);
});
