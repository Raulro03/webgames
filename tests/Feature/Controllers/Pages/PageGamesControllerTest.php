<?php

use App\Models\Developer;
use App\Models\Game;
use App\Models\User;
use function Pest\Laravel\{get, delete};

beforeEach(function () {
    ConfirmRolesExist();
    $this->admin = User::factory()->create()->assignRole('admin');
});

it('loads the games index page', function () {
    $response = get(route('games'));
    $response->assertOk();
    $response->assertViewIs('pages.games');
});

it('loads the game show page', function () {
    $developer = Developer::factory()->create();
    $game = Game::factory()->create(['developer_id' => $developer->id]);
    loginAsUser($this->admin);

    $response = get(route('games.show', $game));

    $response->assertOk();
    $response->assertViewIs('shows.game');
    $response->assertViewHas('game', $game);
});

it('loads the create game page', function () {
    loginAsUser($this->admin);
    $response = get(route('games.create'));

    $response->assertOk();
    $response->assertViewIs('games.create');
});

it('loads the edit game page', function () {
    loginAsUser($this->admin);
    $developer = Developer::factory()->create();
    $game = Game::factory()->create(['developer_id' => $developer->id]);

    $response = get(route('games.edit', $game));

    $response->assertOk();
    $response->assertViewIs('games.edit');
    $response->assertViewHas('game', $game);
});

it('deletes a game', function () {
    loginAsUser($this->admin);
    $developer = Developer::factory()->create();
    $game = Game::factory()->create(['developer_id' => $developer->id, 'image_url' => 'images/games/sample.jpg']);

    Storage::fake('public');

    Storage::disk('public')->put($game->image_url, 'fake content');
    expect(Storage::disk('public')->exists($game->image_url))->toBeTrue();

    $response = delete(route('games.destroy', $game));

    $response->assertRedirect(route('games'));
    $response->assertSessionHas('status', 'Juego eliminado exitosamente!');

    expect(Storage::disk('public')->exists($game->image_url))->toBeFalse();

    expect(Game::find($game->id))->toBeNull();
});
