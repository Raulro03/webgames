<?php

use App\Models\Platform;
use function Pest\Laravel\{getJson};

it('retrieves all platforms', function () {
    Platform::factory()->create();

    $response = getJson('/api/platforms');

    $response->assertOk()
    ->assertJsonCount(1, 'data');
});

it('retrieves a single platform', function () {
    $platform = Platform::factory()->create();

    $response = getJson("/api/platforms/{$platform->id}");

    $response->assertOk()
        ->assertJson([
            'id' => $platform->id,
            'name' => $platform->name,
        ]);
});

it('returns 404 if platform does not exist', function () {
    $response = getJson('/api/platforms/99999');

    $response->assertNotFound()
    ->assertJson(['error' => 'Platform not found']);
});


