<?php

use App\Models\Category;
use App\Models\Developer;
use App\Models\Game;

it('creates a category', function () {
    $category = Category::factory()->create(['name' => 'Action']);

    expect($category)->toBeInstanceOf(Category::class)
        ->and($category->name)->toBe('Action');
});

it('has many games', function () {
    $category = Category::factory()->create();
    $developer = Developer::factory()->create();
    $games = Game::factory()->count(3)->create(['developer_id' => $developer->id]);

    $category->games()->attach($games->pluck('id'));

    expect($category->games)->toHaveCount(3);
});
