<?php

use App\Models\Character;
use App\Models\Game;
use function Pest\Laravel\get;

it('displays the navigation bar', function () {
    // Act & Assert
    get(route('welcome'))
        ->assertOk()
        ->assertSee('WebGames')
        ->assertSee('Inicio')
        ->assertSee('Juegos')
        ->assertSee('Personajes')
        ->assertSee('Foro');
});

it('displays the welcome message', function () {
    // Act & Assert
    get(route('welcome'))
        ->assertOk()
        ->assertSeeText('¡Bienvenido a WebGames!')
        ->assertSeeText('Descubre y comparte tu pasión por los videojuegos.');
});

it('displays login link if not logged in', function () {
    // Act & Assert
    get(route('welcome'))
        ->assertOk()
        ->assertSeeText('Login')
        ->assertSee(route('login'));
});

it('displays logout link if logged in', function () {
    // Act & Assert
    loginAsUser();
    get(route('welcome'))
        ->assertOk()
        ->assertSeeText('Cerrar sesión')
        ->assertSee(route('logout'));
});

it('displays links to the game pages', function () {
    // Arrange

    // Act & Assert
    get(route('welcome'))
        ->assertOk()
        ->assertSee(route('games'));
});

it('displays the characters section', function () {
    // Arrange
    // Act & Assert
    get(route('welcome'))
        ->assertOk()
        ->assertSee('characters');
});

it('displays the forum link', function () {
    // Act & Assert
    get(route('welcome'))
        ->assertOk()
        ->assertSeeText('Foro')
        ->assertSee(route('forum'));
});
