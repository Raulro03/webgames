<?php

use App\Models\Comment;
use App\Models\User;
use function Pest\Laravel\{get, post, patch, delete};

it('shows the comment creation form', function () {
    $post = CreateUserAuth_Post();

    $response = get(route('comment.create', $post->id));

    $response->assertOk();
    $response->assertViewIs('comment.create');
    $response->assertViewHas('post');
});

it('allows a user to create a comment', function () {
    $post = CreateUserAuth_Post();

    $data = [
        'post_id' => $post->id,
        'body' => 'This is a test comment',
        'parent_id' => null
    ];

    $response = post(route('comment.store', ['post' => $post->id]), $data);

    $response->assertRedirect(route('post.show', $post->id));
    expect(Comment::where('body', 'This is a test comment')->exists())->toBeTrue();
});

it('does not allow unauthenticated users to create a comment', function () {
    $post = CreateUser_Post();

    $data = ['post_id' => $post->id, 'body' => 'Unauthorized comment'];

    $response = post(route('comment.store', ['post' => $post->id]), $data);

    $response->assertRedirect(route('login'));
    expect(Comment::where('body', 'Unauthorized comment')->exists())->toBeFalse();
});

it('shows the comment edit form', function () {
    ConfirmRolesExist();
    $post = CreateUserAuth_Post();
    $user = $post->user;

    $user->assignRole('author');
    loginAsUser($user);

    $comment = Comment::factory()->create(['post_id' => $post->id, 'user_id' => $post->user->id]);


    $response = get(route('comment.edit', ['post' => $post->id, 'comment' => $comment->id]));

    $response->assertOk();
    $response->assertViewIs('comment.edit');
    $response->assertViewHas('comment');
});

it('prevents unauthorized users from editing a comment', function () {
    $post = CreateUserAuth_Post();

    loginAsUser($post->user);
    $comment = Comment::factory()->create(['post_id' => $post->id, 'user_id' => $post->user->id]);

    $response = get(route('comment.edit', [$post->id, $comment->id]));

    $response->assertForbidden();
});

it('allows a user to update their comment', function () {
    ConfirmRolesExist();
    $post = CreateUserAuth_Post();
    $user = $post->user;

    $user->assignRole('author');
    loginAsUser($user);

    $comment = Comment::factory()->create(['post_id' => $post->id, 'user_id' => $post->user->id]);

    $updatedData = ['body' => 'Updated comment text',
        'post_id' => $post->id];

    $response = patch(route('comment.update', [$post->id, $comment->id]), $updatedData);

    $response->assertRedirect(route('post.show', $post->id));
    expect($comment->fresh()->body)->toBe('Updated comment text');
});

it('prevents unauthorized users from updating a comment', function () {
    ConfirmRolesExist();
    $post = CreateUserAuth_Post();
    $user = $post->user;

    $user->assignRole('author');
    loginAsUser($user);

    $otherUser = User::factory()->create();

    $comment = Comment::factory()->create(['post_id' => $post->id, 'user_id' => $otherUser->id]);

    $updatedData = ['body' => 'Attempted unauthorized update',
        'post_id' => $post->id];

    $response = patch(route('comment.update', [$post->id, $comment->id]), $updatedData);

    $response->assertForbidden();
    expect($comment->fresh()->body)->not->toBe('Attempted unauthorized update');
});

it('allows a user to delete their comment', function () {
    ConfirmRolesExist();
    $post = CreateUserAuth_Post();
    $user = $post->user;

    $user->assignRole('author');
    loginAsUser($user);
    $comment = Comment::factory()->create(['post_id' => $post->id, 'user_id' => $user->id]);

    $response = delete(route('comment.destroy', [$post->id, $comment->id]));

    $response->assertRedirect(route('post.show', $post->id));
    expect(Comment::find($comment->id))->toBeNull();
});

it('prevents unauthorized users from deleting a comment', function () {
    ConfirmRolesExist();
    $post = CreateUserAuth_Post();
    $user = $post->user;

    $user->assignRole('author');
    loginAsUser($user);

    $otherUser = User::factory()->create();
    $comment = Comment::factory()->create(['post_id' => $post->id, 'user_id' => $otherUser->id]);

    $response = delete(route('comment.destroy', [$post->id, $comment->id]));

    $response->assertForbidden();
    expect(Comment::find($comment->id))->not->toBeNull();
});

it('shows the users comments', function () {
    ConfirmRolesExist();
    $post = CreateUserAuth_Post();
    $user = $post->user;

    $user->assignRole('author');
    loginAsUser($user);

    Comment::factory()->count(3)->create(['post_id' => $post->id ,'user_id' => $user->id]);

    $response = get(route('comments.my-comments'));

    $response->assertOk();
    $response->assertViewIs('comment.my-comments');
    $response->assertViewHas('comments');
});
