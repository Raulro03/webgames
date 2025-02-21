<?php

use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Models\Category;
use App\Models\Character;
use App\Models\Comment;
use App\Models\Developer;
use App\Models\ForumCategory;
use App\Models\Game;
use App\Models\Platform;

beforeEach(function () {
    $this->seed();
});

it('ensures the database seeder runs successfully', function () {

    expect(User::count())->toBeGreaterThanOrEqual(5);
    expect(Role::count())->toBeGreaterThanOrEqual(2);
    expect(Category::count())->toBeGreaterThan(0);
    expect(Character::count())->toBeGreaterThan(0);
    expect(Comment::count())->toBeGreaterThan(0);
    expect(Developer::count())->toBeGreaterThan(0);
    expect(ForumCategory::count())->toBeGreaterThan(0);
    expect(Game::count())->toBeGreaterThan(0);
    expect(Platform::count())->toBeGreaterThan(0);
});

it('ensures roles are seeded correctly', function () {
    expect(Role::where('name', 'admin')->exists())->toBeTrue();
    expect(Role::where('name', 'author')->exists())->toBeTrue();
});

it('ensures users are assigned roles correctly', function () {
    $admin = User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->count();
    $authors = User::whereHas('roles', fn($q) => $q->where('name', 'author'))->count();
    $regularUsers = User::whereHas('roles', fn($q) => $q->where('name', 'user'))->count();

    expect($admin)->toBeGreaterThanOrEqual(1);
    expect($authors + $regularUsers)->toBeGreaterThanOrEqual(4);
});

it('ensures each category type is populated', function () {
    expect(Category::count())->toBeGreaterThan(0);
    expect(ForumCategory::count())->toBeGreaterThan(0);
});

it('ensures games, characters, and platforms exist', function () {
    expect(Game::count())->toBeGreaterThan(0);
    expect(Character::count())->toBeGreaterThan(0);
    expect(Platform::count())->toBeGreaterThan(0);
});

it('ensures comments are linked to posts', function () {
    expect(Comment::whereNotNull('post_id')->count())->toBeGreaterThan(0);
});

it('ensures developers are linked to games', function () {
    expect(Developer::whereHas('games')->count())->toBeGreaterThan(0);
});
