<?php

use function Pest\Laravel\get;

it('displays the navigation bar', function () {
    // Act & Assert
    get(route('welcome'))
        ->assertOk()
        ->assertSee('WebGames')  // Verifica que el logo esté presente
        ->assertSee('Inicio')    // Verifica que el enlace "Inicio" esté presente
        ->assertSee('Juegos')    // Verifica que el enlace "Juegos" esté presente
        ->assertSee('Personajes') // Verifica que el enlace "Personajes" esté presente
        ->assertSee('Foro');     // Verifica que el enlace "Foro" esté presente
});

it('displays the welcome message', function () {
    // Act & Assert
    get(route('welcome'))
        ->assertOk()
        ->assertSeeText('¡Bienvenido a WebGames!')  // Verifica que el mensaje de bienvenida esté presente
        ->assertSeeText('Descubre y comparte tu pasión por los videojuegos.');  // Verifica el subtítulo
});

it('displays login link if not logged in', function () {
    // Act & Assert
    get(route('welcome'))
        ->assertOk()
        ->assertSeeText('Login')  // Verifica que el enlace de login esté presente
        ->assertSee(route('login'));  // Verifica que la ruta de login esté en el enlace
});

it('displays logout link if logged in', function () {
    // Act & Assert
    loginAsUser();  // Metodo para autenticicar al usuario
    get(route('welcome'))
        ->assertOk()
        ->assertSeeText('Log out')  // Verifica que el enlace de logout esté presente
        ->assertSee(route('logout'));  // Verifica que la ruta de logout esté en el enlace
});

it('displays links to the game pages', function () {
    // Arrange
    $firstGame = Game::factory()->create();  // Asegúrate de tener un modelo Game con fábrica
    $secondGame = Game::factory()->create();

    // Act & Assert
    get(route('welcome'))
        ->assertOk()
        ->assertSee(route('games.show', $firstGame))  // Verifica que el enlace al primer juego esté presente
        ->assertSee(route('games.show', $secondGame));  // Verifica que el enlace al segundo juego esté presente
});

it('displays the characters section', function () {
    // Arrange
    $character = Character::factory()->create();  // Asegúrate de tener un modelo Character con fábrica

    // Act & Assert
    get(route('welcome'))
        ->assertOk()
        ->assertSee('Personajes')  // Verifica que la sección de personajes esté presente
        ->assertSeeText($character->name);  // Verifica que el nombre del personaje esté presente
});

it('displays the forum link', function () {
    // Act & Assert
    get(route('welcome'))
        ->assertOk()
        ->assertSeeText('Foro')  // Verifica que el enlace del foro esté presente
        ->assertSee(route('forum.index'));  // Verifica que la ruta al foro esté presente
});
