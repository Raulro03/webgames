<?php

use App\Jobs\CleanTrashedPosts;
use App\Jobs\DeleteOldArchivedPosts;
use App\Models\ForbiddenWord;
use App\Models\Post;
use App\Models\User;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

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

it('dispatches DeleteOldArchivedPosts job', function () {
    Bus::fake();

    ConfirmRolesExist();
    $post = CreateUserAuth_Post();
    $user = $post->user;
    $user->assignRole('admin');

    Post::factory()->create([
        'user_id' => $user->id,
        'category_id' => 1,
        'status' => 'archived',
        'published_at' => now()->subYears(6),
    ]);

    $response = $this->post(route('dashboard.deleteArchivedPosts'));

    $response->assertRedirect();
    $response->assertSessionHas('status', 'Los posts archivados antiguos han sido eliminados.');

    Bus::assertDispatched(DeleteOldArchivedPosts::class);
});

it('dispatches CleanTrashedPosts job', function () {
    Bus::fake();

    ConfirmRolesExist();
    $trashedPost = CreateUserAuth_Post();
    $user = $trashedPost->user;
    $user->assignRole('admin');

    $trashedPost->delete();

    $response = $this->post(route('dashboard.CleanTrashedPosts'));

    $response->assertRedirect();
    $response->assertSessionHas('status', 'Los posts en la papelera han sido eliminados.');

    Bus::assertDispatched(CleanTrashedPosts::class);
});

it('can accept a forbidden word', function () {
    Bus::fake();

    ConfirmRolesExist();
    $user = loginAsUser();
    $user->assignRole('admin');

    $word = ForbiddenWord::factory()->create(['status' => 'pending']);

    $response = $this->post(route('admin.forbidden-words.manage', $word->id), [
        'action' => 'accept',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('status', "Palabra accept correctamente.");

    expect($word->fresh()->status)->toBe('accept');
});

it('can decline a forbidden word', function () {
    ConfirmRolesExist();
    $user = loginAsUser();
    $user->assignRole('admin');

    $word = ForbiddenWord::factory()->create(['status' => 'pending']);

    $response = $this->post(route('admin.forbidden-words.manage', $word->id), [
        'action' => 'decline',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('status', 'Palabra decline correctamente.');

    expect($word->fresh()->status)->toBe('decline');
});

it('validates action when managing forbidden words', function () {
    ConfirmRolesExist();
    $user = loginAsUser();
    $user->assignRole('admin');

    $word = ForbiddenWord::factory()->create();

    $response = $this->post(route('admin.forbidden-words.manage', $word->id), [
        'action' => 'invalid',
    ]);

    $response->assertSessionHasErrors('action');
});

