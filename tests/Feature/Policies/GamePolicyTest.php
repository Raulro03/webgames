<?php

use App\Models\Developer;
use App\Models\User;
use App\Models\Game;
use App\Policies\GamePolicy;
use Illuminate\Support\Carbon;

beforeEach(function () {
    ConfirmRolesExist();
    $this->policy = new GamePolicy();

    // Crear usuarios con diferentes roles
    $this->admin = User::factory()->create()->assignRole('admin');
    $this->moderator = User::factory()->create()->assignRole('moderator');
    $this->user = User::factory()->create(); // Sin roles

    $developer = Developer::factory()->create();

    // Crear un juego ejemplo
    $this->recentGame = Game::factory()->create([
        'release_date' => Carbon::now()->subMonths(6),
        'average_rating' => 3.5,
        'developer_id' => $developer->id,
    ]);

    $this->oldGameHighRating = Game::factory()->create([
        'release_date' => Carbon::now()->subYears(2),
        'average_rating' => 4.5,
        'developer_id' => $developer->id,

    ]);

    $this->oldGameLowRating = Game::factory()->create([
        'release_date' => Carbon::now()->subYears(2),
        'average_rating' => 3.0,
        'developer_id' => $developer->id,

    ]);
});

it('allows admin to do anything via before method', function () {
    expect($this->policy->before($this->admin, 'create'))->toBeTrue();
    expect($this->policy->before($this->admin, 'update'))->toBeTrue();
    expect($this->policy->before($this->admin, 'delete'))->toBeTrue();
});

it('allows moderator to create', function () {
    expect($this->policy->create($this->moderator))->toBeTrue();
});

it('denies regular user to create', function () {
    expect($this->policy->create($this->user))->toBeFalse();
});

it('allows moderator to update only if game released at least 1 year ago', function () {
    expect($this->policy->update($this->moderator, $this->oldGameHighRating))->toBeTrue();
    expect($this->policy->update($this->moderator, $this->recentGame))->toBeFalse();
});

it('denies regular user to update any game', function () {
    expect($this->policy->update($this->user, $this->oldGameHighRating))->toBeFalse();
});

it('allows moderator to delete if rating < 4 and released at least 1 year ago', function () {
    expect($this->policy->delete($this->moderator, $this->oldGameLowRating))->toBeTrue();
    expect($this->policy->delete($this->moderator, $this->oldGameHighRating))->toBeFalse();
    expect($this->policy->delete($this->moderator, $this->recentGame))->toBeFalse();
});

it('denies regular user to delete any game', function () {
    expect($this->policy->delete($this->user, $this->oldGameLowRating))->toBeFalse();
});
