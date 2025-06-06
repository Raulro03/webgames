<?php

use App\Models\User;
use function Pest\Laravel\{get, post, delete};

beforeEach(function () {
    ConfirmRolesExist();
});

it('an admin can access the user management view and sees all users except self', function () {
    $admin = User::factory()->create()->assignRole('admin');
    loginAsUser($admin);

    User::factory()->count(3)->create();

    $response = get(route('admin.users'));

    $response->assertOk()
        ->assertViewIs('admin.users-index')
        ->assertViewHas('users', function ($users) use ($admin) {
            return $users->contains('id', $admin->id) === false
                && $users->count() === 3;
        });
});

it('an admin can assign the admin role to a user', function () {
    $admin = User::factory()->create()->assignRole('admin');
    $user = User::factory()->create();

    loginAsUser($admin);

    $response = post(route('admin.users-make-admin', $user));

    $response->assertRedirect();
    $response->assertSessionHas('status', 'El usuario ahora es administrador.');
    expect($user->fresh()->hasRole('admin'))->toBeTrue();
});

it('an admin can reassign the moderator role to a user', function () {
    $admin = User::factory()->create()->assignRole('admin');
    $user = User::factory()->create()->assignRole('admin');

    loginAsUser($admin);

    $response = post(route('admin.users.make-moderator', $user));

    $response->assertRedirect();
    $response->assertSessionHas('status', 'El usuario ahora es moderador.');
    expect($user->fresh()->hasRole('moderator'))->toBeTrue();
    expect($user->fresh()->hasRole('admin'))->toBeFalse();
});

it('an admin can remove a removable role (author or moderator)', function () {
    $admin = User::factory()->create()->assignRole('admin');
    $user = User::factory()->create()->assignRole('moderator');

    loginAsUser($admin);

    $response = post(route('admin.users.remove-role', $user));

    $response->assertRedirect();
    $response->assertSessionHas('status', 'Rol eliminado correctamente.');
    expect($user->fresh()->roles)->toHaveCount(0);
});

it('does not remove non-removable roles (admin)', function () {
    $admin = User::factory()->create()->assignRole('admin');
    $user = User::factory()->create()->assignRole('admin');

    loginAsUser($admin);

    $response = post(route('admin.users.remove-role', $user));

    $response->assertRedirect();
    $response->assertSessionHas('status', 'Este usuario no tiene un rol removable.');
    expect($user->fresh()->hasRole('admin'))->toBeTrue();
});

it('an admin can delete a user', function () {
    $admin = User::factory()->create()->assignRole('admin');
    $user = User::factory()->create();

    loginAsUser($admin);

    $response = delete(route('admin.users-delete', $user));

    $response->assertRedirect(route('dashboard'));
    $response->assertSessionHas('status', 'User deleted successfully.');
    expect(User::find($user->id))->toBeNull();
});

it('a non-admin cannot access user management features', function () {
    $user = User::factory()->create();

    loginAsUser($user);

    get(route('admin.users'))->assertForbidden();
    post(route('admin.users-make-admin', $user))->assertForbidden();
    post(route('admin.users.make-moderator', $user))->assertForbidden();
    post(route('admin.users.remove-role', $user))->assertForbidden();
    delete(route('admin.users-delete', $user))->assertForbidden();
});
