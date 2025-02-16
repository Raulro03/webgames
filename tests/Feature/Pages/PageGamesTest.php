<?php

use App\Models\Game;
use App\Models\Platform;

beforeEach(function () {
    $this->seed();
});

it('loads the games page', function () {
    $response = $this->get(route('games'));
    $response->assertStatus(200);
    $response->assertViewIs('pages.games');
});

it('displays a list of games', function () {
    $game = Game::first();
    expect($game)->not->toBeNull();

    $response = $this->get(route('games'));
    $response->assertSee($game->title);
});

it('has working pagination', function () {

    $response = $this->get(route('games'));

    $response->assertSee('aria-label="&amp;laquo; Anterior"', false)
    ->assertSee('aria-label="Siguiente &amp;raquo;"', false)
    ->assertSee('<svg', false);
});

it('has game links leading to game details', function () {
    $game = Game::first();

    $response = $this->get(route('games'));
    $response->assertSee(route('games.show', $game->id));
});

