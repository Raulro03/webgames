<?php

use App\Models\User;
use App\Policies\CharacterPolicy;

beforeEach(function () {
    ConfirmRolesExist();
    $this->policy = new CharacterPolicy();

    $this->admin = User::factory()->create()->assignRole('admin');
    $this->moderator = User::factory()->create()->assignRole('moderator');
    $this->user = User::factory()->create(); // Sin roles
});

it('allows admin and moderator all abilities via before method', function () {
    expect($this->policy->before($this->admin, 'create'))->toBeTrue();
    expect($this->policy->before($this->admin, 'update'))->toBeTrue();
    expect($this->policy->before($this->admin, 'delete'))->toBeTrue();

    expect($this->policy->before($this->moderator, 'create'))->toBeTrue();
    expect($this->policy->before($this->moderator, 'update'))->toBeTrue();
    expect($this->policy->before($this->moderator, 'delete'))->toBeTrue();
});

it('returns null from before for normal user', function () {
    expect($this->policy->before($this->user, 'create'))->toBeNull();
    expect($this->policy->before($this->user, 'update'))->toBeNull();
    expect($this->policy->before($this->user, 'delete'))->toBeNull();
});

it('denies create, update, delete for all users via explicit methods', function () {
    // The methods do not receive arguments and always return false
    expect($this->policy->create())->toBeFalse();
    expect($this->policy->update())->toBeFalse();
    expect($this->policy->delete())->toBeFalse();
});
