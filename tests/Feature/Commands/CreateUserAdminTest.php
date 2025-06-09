<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\artisan;

beforeEach(function () {
    ConfirmRolesExist();
});

it('crea un nuevo usuario con rol admin', function () {
    artisan('app:create-admin', [
        'email' => 'nuevo@admin.com',
        '--name' => 'Nuevo Admin',
        '--password' => 'secret123',
    ])
        ->expectsOutput('Usuario administrador creado: nuevo@admin.com')
        ->assertExitCode(0);

    $user = User::where('email', 'nuevo@admin.com')->first();

    expect($user)->not()->toBeNull()
        ->and(Hash::check('secret123', $user->password))->toBeTrue()
        ->and($user->hasRole('admin'))->toBeTrue();
});

it('asigna rol admin a un usuario existente sin rol', function () {
    $user = User::factory()->create(['email' => 'yaexiste@admin.com']);

    artisan('app:create-admin', ['email' => 'yaexiste@admin.com'])
        ->expectsOutput('Rol \'admin\' asignado al usuario existente: yaexiste@admin.com')
        ->assertExitCode(0);

    expect($user->fresh()->hasRole('admin'))->toBeTrue();
});

it('no modifica al usuario si ya es admin', function () {
    $user = User::factory()->create(['email' => 'admin@admin.com']);
    $user->assignRole('admin');

    artisan('app:create-admin', ['email' => 'admin@admin.com'])
        ->expectsOutput("El usuario admin@admin.com ya tiene el rol 'admin'.")
        ->assertExitCode(0);

    expect($user->fresh()->hasRole('admin'))->toBeTrue();
});
