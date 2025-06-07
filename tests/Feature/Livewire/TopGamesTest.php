<?php

use Illuminate\Support\Facades\Http;
use Livewire\Livewire;
use App\Livewire\TopGames;

use function Pest\Laravel\get;

beforeEach(function () {

    Http::fake([
        'https://id.twitch.tv/oauth2/token' => Http::response([
            'access_token' => 'fake-token',
        ], 200),
    ]);


    Http::fake([
        'https://api.igdb.com/v4/popularity_primitives' => Http::response([
            ['game_id' => 1, 'value' => 999, 'popularity_type' => 1],
            ['game_id' => 2, 'value' => 888, 'popularity_type' => 1],
        ], 200),

        'https://api.igdb.com/v4/games' => function ($request) {
            if (str_contains($request->body(), 'id = 1')) {
                return Http::response([
                    ['name' => 'Fake Game 1', 'cover' => ['url' => 'cover1.jpg'], 'rating' => 85, 'url' => 'url1']
                ], 200);
            }

            if (str_contains($request->body(), 'id = 2')) {
                return Http::response([
                    ['name' => 'Fake Game 2', 'cover' => ['url' => 'cover2.jpg'], 'rating' => 90, 'url' => 'url2']
                ], 200);
            }

            return Http::response([], 200);
        }
    ]);
});

it('loads top games on mount', function () {
    Livewire::test(TopGames::class)
        ->assertViewHas('games')
        ->assertSet('limit', 10)
        ->assertSee('Fake Game 1')
        ->assertSee('Fake Game 2');
});

it('loads more games when loadMore is called', function () {
    Livewire::test(TopGames::class)
        ->call('loadMore')
        ->assertSet('limit', 20);
});

it('loads fewer games when loadLess is called', function () {
    Livewire::test(TopGames::class)
        ->call('loadMore') // primero subir a 20
        ->call('loadLess') // volver a 10
        ->assertSet('limit', 10);
});

it('does not go below 10 games', function () {
    Livewire::test(TopGames::class)
        ->call('loadLess')
        ->assertSet('limit', 10);
});
