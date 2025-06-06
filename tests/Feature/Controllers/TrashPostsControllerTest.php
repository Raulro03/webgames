<?php

use App\Models\Post;
use Illuminate\Support\Facades\Gate;

it('displays posts in the authenticated user trash', function () {
    ConfirmRolesExist();

    $post = CreateUserAuth_Post();

    $post->delete();

    $this->get(route('posts.trash-posts'))
        ->assertOk()
        ->assertViewIs('forum.trash-posts')
        ->assertViewHas('posts', function ($posts) use ($post) {
            return $posts->contains($post);
        });
});

it('restore a deleted post if authorized', function () {
    ConfirmRolesExist();

    $post = CreateUserAuth_Post();

    $post->user->assignRole('author');

    $post->delete();

    Gate::define('restore', fn ($authUser, $p) => $authUser->is($p->user));

    $this->patch(route('posts.restore', $post->id))
        ->assertRedirect(route('forum'))
        ->assertSessionHas('status', 'Post restores successfully!');

    expect(Post::find($post->id))->not->toBeNull();
});

it('permanently delete a post if authorized', function () {
    ConfirmRolesExist();

    $post = CreateUserAuth_Post();
    $post->user->assignRole('author');
    $post->delete();

    Gate::define('forceDelete', fn ($authUser, $p) => $authUser->is($p->user));

    $this->delete(route('posts.forceDelete', $post->id))
        ->assertRedirect(route('forum'))
        ->assertSessionHas('status', 'Post deletes permanently!');

    expect(Post::withTrashed()->find($post->id))->toBeNull();
});
