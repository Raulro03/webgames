<?php

use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

it('generates a user token successfully', function () {

    $user = User::factory()->create([
        'email' => 'test@example.com',
    ]);

    Artisan::call('app:generate-user-token', ['email' => $user->email]);

    $output = Artisan::output();

    expect($output)->toContain("El token del usuario {$user->email} es:");

    $this->assertFileExists(storage_path('app/tokens.txt'));
});

it('shows an error when the user does not exist', function () {

    Artisan::call('app:generate-user-token', ['email' => 'nonexistent@example.com']);


    $output = Artisan::output();

    expect($output)->toContain('No se encontró un usuario con el email nonexistent@example.com');
});
