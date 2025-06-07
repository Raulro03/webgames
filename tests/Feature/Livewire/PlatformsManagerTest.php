<?php

use App\Livewire\PlatformsManager;
use App\Models\Platform;
use Illuminate\Http\UploadedFile;

it('can create a platform with games and sales', function () {
    adminUser();
    $game = CreateGameWithDeveloper();
    $image = UploadedFile::fake()->image('platform.jpg');

    Livewire::test(PlatformsManager::class)
        ->call('create')
        ->set('name', 'PlayStation 5')
        ->set('description', 'Next-gen console')
        ->set('release_date', '2020-11-12')
        ->set('price', 49999)
        ->set('average_rating', 4.9)
        ->set('image', $image)
        ->call('toggleGames', $game->id)
        ->set("gamesSales.$game->id", 500000)
        ->call('store');

    $this->assertDatabaseHas('platforms', ['name' => 'PlayStation 5']);
    $platform = Platform::where('name', 'PlayStation 5')->first();
    expect($platform->games()->first()->pivot->sales)->toBe(500000);
    Storage::disk('public')->assertExists($platform->image_url);
});

it('validates required fields when creating', function () {
    adminUser();

    Livewire::test(PlatformsManager::class)
        ->call('create')
        ->set('name', '')
        ->set('release_date', '')
        ->call('store')
        ->assertHasErrors([
            'name' => 'required',
            'release_date' => 'required',
        ]);
});

it('forbids unauthorized user from opening create modal', function () {
    loginAsUser();

    Livewire::test(PlatformsManager::class)
        ->call('create')
        ->assertForbidden();
});

it('forbids unauthorized user from storing platform', function () {
    loginAsUser();

    Livewire::test(PlatformsManager::class)
        ->call('store')
        ->assertForbidden();
});

it('can edit and update a platform', function () {
    adminUser();

    $platform = Platform::factory()->create(['name' => 'PS4']);
    $game = CreateGameWithDeveloper();

    Livewire::test(PlatformsManager::class)
        ->call('edit', $platform->id)
        ->set('name', 'PS4 Updated')
        ->call('toggleGames', $game->id)
        ->set("gamesSales.$game->id", 123456)
        ->call('update');

    $this->assertDatabaseHas('platforms', ['name' => 'PS4 Updated']);
    $updated = Platform::find($platform->id);
    expect($updated->games()->first()->pivot->sales)->toBe(123456);
});

it('can delete a platform and detach games', function () {
    adminUser();

    $platform = Platform::factory()->create([
        'image_url' => 'images/platforms/to-delete.jpg',
    ]);

    Storage::disk('public')->put('images/platforms/to-delete.jpg', 'fake');

    Livewire::test(PlatformsManager::class)
        ->call('confirmDelete', $platform->id)
        ->call('delete');

    $this->assertDatabaseMissing('platforms', ['id' => $platform->id]);
    Storage::disk('public')->assertMissing('images/platforms/to-delete.jpg');
});

it('filters platforms by search, price and rating', function () {
    adminUser();

    Platform::factory()->create([
        'name' => 'Cheap Console',
        'price' => 100,
        'average_rating' => 3.0,
    ]);
    Platform::factory()->create([
        'name' => 'Expensive Console',
        'price' => 9999,
        'average_rating' => 5.0,
    ]);

    Livewire::test(PlatformsManager::class)
        ->set('search', 'Expensive')
        ->set('min_price', 9)
        ->set('max_price', 10000)
        ->set('min_rating', 4)
        ->set('max_rating', 5)
        ->assertSee('Expensive Console')
        ->assertDontSee('Cheap Console');
});

