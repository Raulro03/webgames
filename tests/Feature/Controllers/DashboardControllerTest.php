<?php

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

it('allows an authenticated user to access the dashboard', function () {
    $user = User::factory()->create();
    loginAsUser($user);

    $response = get(route('dashboard'));

    $response->assertOk();
    $response->assertViewIs('dashboard');
    $response->assertViewHas('stats');
});

it('redirects unauthenticated users from the dashboard', function () {
    $response = get(route('dashboard'));

    $response->assertRedirect(route('login'));
});

it('shows the correct stats in the dashboard', function () {
    $post = CreateUserAuth_Post();
    $user = $post->user;

    Comment::factory()->count(10)->create(['post_id' => $post->id, 'user_id' => $user->id]);
    User::factory()->count(3)->create();

    $response = get(route('dashboard'));

    $response->assertViewHas('stats', function ($stats) {
        return $stats['totalPosts'] === 1 &&
            $stats['totalComments'] === 10 &&
            $stats['totalUsers'] >= 4;
    });
});

