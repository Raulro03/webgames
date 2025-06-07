<?php

use App\Models\Platform;
use App\Policies\PlatformPolicy;

it('allows admin via before method in policy', function () {
    $user = adminUser();
    $platform = Platform::factory()->make();

    $policy = new PlatformPolicy;
    expect($policy->before($user))->toBeTrue();
});

it('allows update if user is moderator and platform older than 1 year', function () {
    $user = moderatorUser();
    $platform = Platform::factory()->make([
        'release_date' => now()->subYears(2),
    ]);

    $policy = new PlatformPolicy;
    expect($policy->update($user, $platform))->toBeTrue();
});

it('allows delete if user is moderator, rating < 4, and older than 1 year', function () {
    $user = moderatorUser();
    $platform = Platform::factory()->make([
        'average_rating' => 3.5,
        'release_date' => now()->subYears(2),
    ]);

    $policy = new PlatformPolicy;
    expect($policy->delete($user, $platform))->toBeTrue();
});
