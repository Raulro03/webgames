<?php

use App\Livewire\GameSearch;
use App\Models\Game;

beforeEach(function () {
    Game::factory()->create(['title' => 'Zelda', 'developer_id' => 2, 'average_rating' => 5]);
    Game::factory()->create(['title' => 'Mario', 'developer_id' => 2, 'average_rating' => 4]);
    Game::factory()->create(['title' => 'Metroid', 'developer_id' => 2, 'average_rating' => 4.5]);
});

it('shows games in descending order by default', function () {
    Livewire::test(GameSearch::class)
        ->assertSeeInOrder(['Zelda', 'Metroid', 'Mario']);
});

it('can search for games by title', function () {
    Livewire::test(GameSearch::class)
        ->set('search', 'Mario')
        ->assertSee('Mario')
        ->assertDontSee('Zelda')
        ->assertDontSee('Metroid');
});

it('can toggle ordering between desc and asc', function () {
    $component = Livewire::test(GameSearch::class);

    $component->assertSeeInOrder(['Zelda', 'Metroid', 'Mario']);

    $component->call('toggleOrder')
        ->assertSet('orderBy', 'asc')
        ->assertSeeInOrder(['Mario', 'Metroid', 'Zelda']);
});

