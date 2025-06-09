<?php

use App\Models\Character;
use App\Models\Developer;
use App\Models\Game;
use function Pest\Laravel\{getJson, postJson, patchJson, deleteJson};


it('lists paginated characters with statistics and games', function () {
    Character::factory()->count(15)->hasStatistics()->create();

    $response = getJson('/api/characters');

    $response->assertOk()
        ->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'name',
                    'age',
                    'description',
                    'image_url',
                    'statistics' => [
                        'constitution',
                        'strength',
                        'agility',
                        'intelligence',
                        'charisma',
                    ],
                    'games' => [
                        '*' => [
                            'id',
                            'title',
                            'pivot' => [
                                'appearance',
                            ],
                        ],
                    ],
                    'created_at',
                ]
            ],
            'links',
            'meta',
        ])
        ->assertJsonCount(10, 'data');
});

it('shows a single character with statistics and games', function () {
    $character = Character::factory()
        ->hasStatistics()
        ->hasAttached(CreateGameWithDeveloper(), ['appearance' => now()->toDateString()])
        ->create();

    $response = getJson("/api/characters/{$character->id}");

    $response->assertOk()
        ->assertJsonPath('data.id', $character->id)
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'age',
                'description',
                'image_url',
                'statistics' => [
                    'constitution',
                    'strength',
                    'agility',
                    'intelligence',
                    'charisma',
                ],
                'games' => [
                    '*' => [
                        'id',
                        'title',
                        'pivot' => [
                            'appearance',
                        ],
                    ],
                ],
                'created_at',
            ],
        ]);
});

it('returns 404 when character not found', function () {
    $response = getJson('/api/characters/999999');

    $response->assertNotFound();
});

it('creates a character when authenticated', function () {
    $user = loginAsUser();
    $game = CreateGameWithDeveloper();

    $payload = [
        'name' => 'Geralt',
        'age' => 100,
        'description' => 'Un brujo cazador de monstruos.',
        'statistics' => [
            'constitution' => 10,
            'strength' => 10,
            'agility' => 10,
            'intelligence' => 4,
            'charisma' => 8,
        ],
        'games' => [
            ['id' => $game->id, 'appearance' => now()->toDateString()]
        ],
    ];

    $token = $user->createToken('test')->plainTextToken;

    $response = postJson('/api/characters', $payload, ['Authorization' => "Bearer $token"]);

    $response->assertCreated()
        ->assertJsonPath('data.name', 'Geralt')
        ->assertJsonStructure([
            'data' => [
                'id',
                'name',
                'statistics' => [
                    'constitution',
                    'strength',
                    'agility',
                    'intelligence',
                    'charisma',
                ],
                'games' => [
                    '*' => [
                        'id',
                        'title',
                        'pivot' => [
                            'appearance',
                        ],
                    ],
                ],
            ],
        ]);

    expect(Character::where('name', 'Geralt')->exists())->toBeTrue();
});

it('does not create a character when unauthenticated', function () {
    $payload = ['name' => 'No Auth Character'];

    $response = postJson('/api/characters', $payload);

    $response->assertUnauthorized();
});

it('updates a character when authenticated', function () {
    $character = Character::factory()->hasStatistics()->create();

    $user = loginAsUser();
    $game = CreateGameWithDeveloper();

    $payload = [
        'name' => 'Updated Name',
        'age' => 101,
        'description' => 'Updated description.',
        'statistics' => [
            'constitution' => 10,
            'strength' => 2,
            'agility' => 2,
            'intelligence' => 4,
            'charisma' => 8,
        ],
        'games' => [
            ['id' => $game->id, 'appearance' => now()->toDateString()]
        ],
    ];

    $response = patchJson("/api/characters/{$character->id}", $payload, ['Authorization' => "Bearer {$user->createToken('test')->plainTextToken}"]);

    $response->assertOk()
        ->assertJsonPath('data.name', 'Updated Name');

    expect($character->fresh()->name)->toBe('Updated Name');
});

it('does not update a character when unauthenticated', function () {
    $character = Character::factory()->create();

    $response = patchJson("/api/characters/{$character->id}", ['name' => 'Fail Update']);

    $response->assertUnauthorized();
});

it('deletes a character when authenticated', function () {
    $user = loginAsUser();
    $character = Character::factory()->hasStatistics()->create();

    $response = deleteJson("/api/characters/{$character->id}", [], ['Authorization' => "Bearer {$user->createToken('test')->plainTextToken}"]);

    $response->assertNoContent();

    expect(Character::find($character->id))->toBeNull();
});

it('does not delete a character when unauthenticated', function () {
    $character = Character::factory()->create();

    $response = deleteJson("/api/characters/{$character->id}");

    $response->assertUnauthorized();
});
