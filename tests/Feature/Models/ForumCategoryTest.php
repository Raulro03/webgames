<?php

use App\Models\ForumCategory;
use App\Models\Post;
use App\Models\Platform;
use App\Models\Character;
use App\Models\User;

it('creates a forum category', function () {
    $category = ForumCategory::factory()->create([
        'category_type' => 'game',
        'related_id' => 1,
    ]);

    expect($category)->toBeInstanceOf(ForumCategory::class)
        ->and($category->category_type)->toBe('game')
        ->and($category->related_id)->toBe(1);
});

it('has many posts', function () {
    $user = User::factory()->create();
    $category = ForumCategory::factory()->create();
    Post::factory()->count(3)->create(['category_id' => $category->id, 'user_id' => $user->id]);

    expect($category->posts)->toHaveCount(3);
});

it('returns correct related model for platform', function () {
    $platform = Platform::factory()->create();
    $category = ForumCategory::factory()->create([
        'category_type' => 'platform',
        'related_id' => $platform->id,
    ]);

    expect($category->related)->toBeInstanceOf(Platform::class)
        ->and($category->related->id)->toBe($platform->id);
});

it('returns correct related model for character', function () {
    $character = Character::factory()->create();
    $category = ForumCategory::factory()->create([
        'category_type' => 'character',
        'related_id' => $character->id,
    ]);

    expect($category->related)->toBeInstanceOf(Character::class)
        ->and($category->related->id)->toBe($character->id);
});

