<?php

use App\Models\Developer;
use App\Models\Game;
use function Pest\Laravel\{getJson};

it('retrieves all games', function () {
    Developer::factory()->create();
    Game::factory(5)->create([
        'developer_id' => 1,
    ]);

    $response = getJson('/api/games');

    $response->assertOk()
        ->assertJsonCount(5, 'data');
});

it('retrieves a single game', function () {
    Developer::factory()->create();
    $game = Game::factory()->create([
        'developer_id' => 1,
    ]);

    $response = getJson("/api/games/{$game->id}");

    $response->assertOk()
        ->assertJson([
            'data' => [
                'id' => $game->id,
                'title' => $game->title,
                'description' => $game->description,
                'price' => $game->price,
                'developer_id' => $game->developer_id,
            ]
        ]);
});

it('returns 404 if game does not exist', function () {
    $response = getJson('/api/games/99999');

    $response->assertNotFound()
        ->assertJson(['error' => 'Game not found']);
});

