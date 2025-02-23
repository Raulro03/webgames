<?php

use App\Models\User;
use function Pest\Laravel\{get, post, delete};

it('displays all users in the admin panel', function () {
    ConfirmRolesExist();
    $admin = User::factory()->create()->assignRole('admin');
    loginAsUser($admin);

    User::factory()->count(5)->create();

    $response = get(route('admin.users'));

    $response->assertOk();
    $response->assertViewIs('admin.users-index');
    $response->assertViewHas('users', function () {
        return User::count() === 6;
    });
});

it('allows admin to make another user an admin', function () {
    ConfirmRolesExist();
    $admin = User::factory()->create()->assignRole('admin');
    $user = User::factory()->create();

    loginAsUser($admin);
    $response = post(route('admin.users-make-admin', $user));

    $response->assertRedirect();
    $response->assertSessionHas('status', 'El usuario ahora es administrador.');

    expect($user->fresh()->hasRole('admin'))->toBeTrue();
});

it('does not make a user admin if already admin', function () {
    ConfirmRolesExist();
    $admin = User::factory()->create()->assignRole('admin');
    $user = User::factory()->create()->assignRole('admin');

   loginAsUser($admin);
    $response = post(route('admin.users-make-admin', $user));

    $response->assertRedirect();
    $response->assertSessionHas('status', 'Este usuario ya es administrador.');
});

it('allows admin to delete a user', function () {
    ConfirmRolesExist();
    $admin = User::factory()->create()->assignRole('admin');
    $user = User::factory()->create();

    loginAsUser($admin);
    $response = delete(route('admin.users-delete', $user));

    $response->assertRedirect(route('dashboard'));
    $response->assertSessionHas('status', 'User deleted successfully.');

    expect(User::find($user->id))->toBeNull();
});

it('does not allow non-admins to manage users', function () {
    ConfirmRolesExist();
    $user = User::factory()->create();

    loginAsUser($user);

    get(route('admin.users'))->assertForbidden();
    post(route('admin.users-make-admin', $user))->assertForbidden();
    delete(route('admin.users-delete', $user))->assertForbidden();
});
