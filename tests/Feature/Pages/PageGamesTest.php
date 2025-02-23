<?php

use App\Models\Developer;
use App\Models\Game;

it('loads the games page', function () {
    $response = $this->get(route('games'));
    $response->assertStatus(200);
    $response->assertViewIs('pages.games');
});

it('displays a list of games', function () {
    $developer = Developer::factory()->create();
    $game = Game::factory()->create(['developer_id' => $developer->id]);
    expect($game)->not->toBeNull();

    $response = $this->get(route('games'));
    $response->assertSee($game->title);
});

it('has working pagination', function () {
    $developer = Developer::factory()->create();
    $game = Game::factory(15)->create(['developer_id' => $developer->id]);

    $response = $this->get(route('games'));

    $response->assertSee('aria-label="&amp;laquo; Anterior"', false)
    ->assertSee('aria-label="Siguiente &amp;raquo;"', false)
    ->assertSee('<svg', false);
});

it('has game links leading to game details', function () {
    $developer = Developer::factory()->create();
    $game = Game::factory()->create(['developer_id' => $developer->id]);
    expect($game)->not->toBeNull();

    $response = $this->get(route('games'));

    $response->assertSee(route('games.show', $game->id));
});

