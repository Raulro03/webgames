<?php

use App\Models\Platform;
use App\Models\User;
use function Pest\Laravel\get;

it('loads the platforms index page', function () {
    Platform::factory()->create();

    $response = get(route('platforms'));

    $response->assertOk();
    $response->assertViewIs('pages.platforms');
    $response->assertViewHas('platforms');

});


it('loads the platform show page', function () {
    $user = User::factory()->create();
    loginAsUser($user);

    $platform = Platform::factory()->create();

    $response = get(route('platforms.show', $platform));

    $response->assertOk();
    $response->assertViewIs('shows.platform');
    $response->assertViewHas('platform', $platform);

    $response->assertSee($platform->name);
});
