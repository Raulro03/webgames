<?php

use App\Models\Comment;
use function Pest\Laravel\{getJson, postJson, putJson, deleteJson};


it('receives all comments', function () {
    $this->seed();

    $response = getJson('/api/comments');

    $response->assertOk()
    ->assertJsonStructure(['data', 'links', 'meta']);
});

it('receives a single comment with parent and replies', function () {
    CreateUserAuth_Post();

    $parentComment = Comment::factory()->create(['post_id' => 1, 'user_id' => 1]);
    $reply = Comment::factory()->create(['post_id' => 1, 'user_id' => 1, 'parent_id' => $parentComment->id]);

    $response = getJson("/api/comments/1");

    $response->assertOk()
        ->assertJson([
            'data' => [
                'id' => $parentComment->id,
                'body' => $parentComment->body,
                'published_at' => $parentComment->published_at->toISOString(),
                'parent' => null,
                'replies' => [
                    [
                        'id' => $reply->id,
                        'body' => $reply->body,
                        'published_at' => $reply->published_at->toISOString(),
                    ]
                ]

            ]
        ]);

});

it('returns 404 if comment does not exist', function () {
    $response = getJson('/api/comments/99999'); // 🔹 Un ID que no existe

    $response->assertNotFound();
});

it('creates a comment when authenticated', function () {
    $post = CreateUserAuth_Post();

    $data = [
        'post_id' => $post->id,
        'body' => 'Nuevo comentario',
        'parent_id' => null,
    ];

    $response = postJson('/api/comments', array_merge($data, ['user_id' => $post->user->id, 'published_at' => now()]));

    $response->assertCreated()
        ->assertJsonStructure(['data' => ['id', 'body', 'published_at']]);

    expect(Comment::where('body', 'Nuevo comentario')->exists())->toBeTrue();
});

it('does not create a comment when unauthenticated', function () {
    $post = CreateUser_Post();

    $data = ['post_id' => $post->id, 'body' => 'Comentario no autorizado', 'parent_id' => null];

    $response = postJson('/api/comments', $data);

    $response->assertUnauthorized();
});

it('updates a comment when authenticated', function () {
    $post = CreateUserAuth_Post();

    $comment = Comment::factory()->create(['user_id' => $post->user->id, 'post_id' => $post->id]);
    $updatedData = ['post_id' => $post->id ,'body' => 'Comentario editado'];

    $response = putJson("/api/comments/{$comment->id}", $updatedData);

    $response->assertOk()
        ->assertJsonStructure(['data' => ['id', 'body', 'published_at']]
        );

    expect($comment->fresh()->body)->toBe('Comentario editado');
});

it('does not update a comment when unauthenticated', function () {
    $post = CreateUser_Post();

    $comment = Comment::factory()->create(['user_id' => 1, 'post_id' => $post->id]);
    $updatedData = ['post_id' => $post->id ,'body' => 'Comentario editado'];

    $response = putJson("/api/comments/{$comment->id}", $updatedData);

    $response->assertUnauthorized();
});

it('deletes a comment when authenticated', function () {
    $post = CreateUserAuth_Post();

    $comment = Comment::factory()->create(['user_id' => 1, 'post_id' => $post->id]);

    $response = deleteJson("/api/comments/{$comment->id}");

    $response->assertNoContent();

    expect(Comment::find($comment->id))->toBeNull();
});

it('does not delete a comment when unauthenticated', function () {
    $post = CreateUser_Post();

    $comment = Comment::factory()->create(['user_id' => 1, 'post_id' => $post->id]);

    $response = deleteJson("/api/comments/{$comment->id}");

    $response->assertUnauthorized();
});
