<?php

use App\Models\ForumCategory;
use App\Models\Post;
use App\Models\User;
use function Pest\Laravel\{get, post, put, delete};

it('loads the forum index page', function () {
    $response = get(route('forum'));
    $response->assertOk();
    $response->assertViewIs('pages.forum');
});

it('displays posts of a given category', function () {
    $user = User::factory()->create();

    $category = ForumCategory::factory()->create(['category_type' => 'general']);
    $post = Post::factory()->create([
        'user_id' => $user->id,
        'category_id' => $category->id,
        'status' => 'published'
    ]);

    $response = get(route('forum.category', [$post->forum_category->category_type]));

    $response->assertOk();
    $response->assertViewIs('forum.category');
    $response->assertViewHas('posts');
    $response->assertSee($post->title);
});

it('shows a single post', function () {
    $post = CreateUserAuth_Post();

    $response = get(route('post.show', ['post' => $post->id]));

    $response->assertOk();
    $response->assertViewIs('forum.show');
    $response->assertViewHas('post', $post);
});

it('shows the post creation form', function () {
    $user = User::factory()->create();
    loginAsUser($user);

    $response = get(route('post.create'));

    $response->assertOk();
    $response->assertViewIs('forum.create');
    $response->assertViewHas('forumCategories');
});

it('allows an authenticated user to create a post', function () {
    ConfirmRolesExist();
    $user = User::factory()->create();
    loginAsUser($user);

    $category = ForumCategory::factory()->create();

    $postData = [
        'title' => 'New Post',
        'body' => 'This is a test post.',
        'category_id' => $category->id,
        'status' => 'published',
        'published_at' => now(),
    ];

    $response = post(route('post.store'), $postData);

    $response->assertRedirect(route('forum'));
    expect(Post::where('title', 'New Post')->exists())->toBeTrue();
});

it('prevents unauthenticated users from creating a post', function () {
    $category = ForumCategory::factory()->create();

    $postData = [
        'title' => 'New Post',
        'body' => 'This is a test post.',
        'category_id' => $category->id,
        'status' => 'published',
        'published_at' => now(),
    ];

    $response = post(route('post.store'), $postData);

    $response->assertRedirect(route('login'));
    expect(Post::where('title', 'New Post')->exists())->toBeFalse();
});

it('shows the edit post form for authorized users', function () {
    ConfirmRolesExist();
    $post = CreateUserAuth_Post();
    $post->user->assignRole('author');

    $response = get(route('post.edit', ['post' => $post->id]));

    $response->assertOk();
    $response->assertViewIs('forum.edit');
    $response->assertViewHas('post');
});

it('prevents unauthorized users from editing a post', function () {
    ConfirmRolesExist();

    $user = User::factory()->create();
    loginAsUser($user);

    $post = Post::factory()->create(['user_id' => $user->id, 'category_id' => ForumCategory::factory()->create()->id]);

    $response = get(route('post.edit', ['post' => $post->id]));

    $response->assertForbidden();
});

it('allows an authorized user to update a post', function () {
    ConfirmRolesExist();
    $post = CreateUserAuth_Post();
    $post->user->assignRole('author');

    $updatedData = ['title' => 'Updated Title', 'body' => 'Updated body', 'category_id' => $post->category_id, 'published_at' => now()];

    $response = put(route('post.update', ['post' => $post->id]), $updatedData);

    $response->assertRedirect(route('post.show', ['post' => $post->id]));
    expect($post->fresh()->title)->toBe('Updated Title');
});

it('prevents unauthorized users from updating a post', function () {
    ConfirmRolesExist();

    $user = User::factory()->create();
    loginAsUser($user);

    $post = Post::factory()->create(['user_id' => $user->id, 'category_id' => ForumCategory::factory()->create()->id]);

    $updatedData = ['title' => 'Updated Title', 'body' => 'Updated body', 'category_id' => $post->category_id, 'published_at' => now()];

    $response = put(route('post.update', ['post' => $post->id]), $updatedData);

    $response->assertForbidden();
    expect($post->fresh()->title)->not->toBe('Updated Title');
});

it('allows an authorized user to delete a post', function () {
    ConfirmRolesExist();
    $post = CreateUserAuth_Post();
    $post->user->assignRole('author');

    $response = delete(route('post.destroy', ['post' => $post->id]));

    $response->assertRedirect(route('forum'));
    expect(Post::find($post->id))->toBeNull();
});

it('prevents unauthorized users from deleting a post', function () {
    ConfirmRolesExist();

    $user = User::factory()->create();
    loginAsUser($user);

    $post = Post::factory()->create(['user_id' => $user->id, 'category_id' => ForumCategory::factory()->create()->id]);

    $response = delete(route('post.destroy', ['post' => $post->id]));

    $response->assertForbidden();
    expect(Post::find($post->id))->not->toBeNull();
});

it('shows the users posts', function () {
    CreateUserAuth_Post();

    $response = get(route('forum.my-posts'));

    $response->assertOk();
    $response->assertViewIs('forum.my-posts');
    $response->assertViewHas('posts');
});
