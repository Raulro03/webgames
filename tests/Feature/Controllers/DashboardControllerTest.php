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

it('redirects admins to admin-dashboard', function () {
    ConfirmRolesExist();
    $post = CreateUserAuth_Post();
    $user = $post->user;
    $user->assignRole('admin');

    $response = get(route('dashboard'));

    $response->assertViewIs('admin-dashboard');
    $response->assertViewHas('stats');
});

it('executes DeleteOldArchivedPosts job when calling deleteArchivedPosts', function () {
    ConfirmRolesExist();
    $post = CreateUserAuth_Post();
    $user = $post->user;
    $user->assignRole('admin');

    $oldPost = Post::factory()->create([
        'user_id' => $user->id,
        'category_id' => 1,
        'status' => 'archived',
        'published_at' => now()->subYears(6),
    ]);

    $response = post(route('dashboard.deleteArchivedPosts'));

    $response->assertRedirect();
    $response->assertSessionHas('status', 'Los posts archivados antiguos han sido eliminados.');

    expect(Post::where('id', $oldPost->id)->exists())->toBeFalse();
});

it('executes the CleanTrashedPosts job when calling cleanTrashPosts', function () {
    ConfirmRolesExist();
    $trashedPost = CreateUserAuth_Post();
    $user = $trashedPost->user;
    $user->assignRole('admin');

    $trashedPost->delete();

    $response = post(route('dashboard.CleanTrashedPosts'));

    $response->assertRedirect();
    $response->assertSessionHas('status', 'Los posts en la papelera han sido eliminados.');

    expect(Post::onlyTrashed()->count())->toBe(0);
});
