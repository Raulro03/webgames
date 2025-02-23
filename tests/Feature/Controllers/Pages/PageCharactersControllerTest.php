<?php

use App\Models\Character;
use App\Models\User;
use function Pest\Laravel\get;

it('loads the character index page', function () {
    Character::factory()->create();

    $response = get(route('characters'));

    $response->assertOk();
    $response->assertViewIs('pages.characters');
    $response->assertViewHas('characters');

});


it('loads the character show page', function () {
    $user = User::factory()->create();
    loginAsUser($user);

    $character = Character::factory()->create();

    $response = get(route('characters.show', $character));

    $response->assertOk();
    $response->assertViewIs('shows.character');
    $response->assertViewHas('character', $character);

    $response->assertSee($character->name);
});
