<?php

use App\Models\ForumCategory;
use App\Models\Post;
use App\Models\User;
use function Pest\Laravel\{getJson, postJson, patchJson, deleteJson, actingAs};

it('retrieves all forum posts', function () {
    $this->seed();

    $response = getJson('/api/posts');

    $response->assertOk()
        ->assertJsonStructure(['data', 'links', 'meta']); // 🔹 Si usa paginación
});

it('retrieves a single forum post', function () {
    $user = User::factory()->create();
    $category = ForumCategory::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = getJson("/api/posts/{$post->id}");

    $response->assertOk()->assertJsonStructure([
        'data' => ['id', 'title', 'body', 'status'],
    ])
        ->assertJson([
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'body' => $post->body,
                'status' => $post->status,
                'comments' => $post->comments->toArray(),
            ]
        ]);
});

it('returns 404 if post does not exist', function () {
    $response = getJson('/api/posts/99999'); // 🔹 ID inexistente

    $response->assertNotFound();
});

it('creates a post when authenticated', function () {
    $user = User::factory()->create();
    actingAs($user);

    $category = ForumCategory::factory()->create();
    $data = [
        'title' => 'Nuevo Post',
        'body' => 'Contenido de prueba',
        'published_at' => now()->toDateTimeString(),
        'category_id' => $category->id,
    ];

    $response = postJson('/api/posts', array_merge($data, ['user_id' => $user->id]));

    $response->assertCreated()
        ->assertJsonStructure(['data' => ['id', 'title', 'body']]);

    expect(Post::where('title', 'Nuevo Post')->exists())->toBeTrue();
});

it('does not create a post when unauthenticated', function () {
    $category = ForumCategory::factory()->create();
    $data = [
        'title' => 'Intento de post sin autenticación',
        'content' => 'Texto de prueba',
        'category_id' => $category->id,
    ];

    $response = postJson('/api/posts', $data);

    $response->assertUnauthorized();
});

it('updates a post when authenticated', function () {
    $user = User::factory()->create();
    actingAs($user);

    $category = ForumCategory::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $updatedData = ['title' => 'Post Editado', 'body' => 'Contenido actualizado', 'published_at' => now()->toDateTimeString(), 'category_id' => $category->id];

    $response = patchJson("/api/posts/{$post->id}", $updatedData);

    $response->assertOk()
        ->assertJsonStructure(['data' => ['id', 'title', 'body', 'published_at']]);

    expect($post->fresh()->title)->toBe('Post Editado');
});

it('does not update a post when unauthenticated', function () {
    $user = User::factory()->create();
    $category = ForumCategory::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $updatedData = ['title' => 'Post Editado', 'content' => 'Nuevo contenido'];

    $response = patchJson("/api/posts/{$post->id}", $updatedData);

    $response->assertUnauthorized();
});

it('deletes a post when authenticated', function () {
    $user = User::factory()->create();
    actingAs($user); // 🔹 Autentica al usuario

    $category = ForumCategory::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = deleteJson("/api/posts/{$post->id}");

    $response->assertNoContent();

    expect(Post::find($post->id))->toBeNull();
});

it('does not delete a post when unauthenticated', function () {
    $user = User::factory()->create();
    $category = ForumCategory::factory()->create();
    $post = Post::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
    ]);

    $response = deleteJson("/api/posts/{$post->id}");

    $response->assertUnauthorized();
});
