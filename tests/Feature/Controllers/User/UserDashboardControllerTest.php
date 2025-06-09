<?php

use App\Models\ForbiddenWord;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

it('generates a token for the authenticated user and returns with message', function () {
    $user = loginAsUser();

    Artisan::spy();

    $this->post(route('user.generate.tokens'))
        ->assertRedirect()
        ->assertSessionHas('success');

    Artisan::shouldHaveReceived('call')->with('app:generate-user-token', ['email' => $user->email]);
});

it('adds forbidden word directly if the user is an admin', function () {
    Bus::fake();

    ConfirmRolesExist();
    $user = loginAsUser();
    $user->assignRole('admin');

    $this->post(route('forbidden-words.request'), [
        'word' => 'maldición'
    ])
        ->assertRedirect()
        ->assertSessionHas('status', 'Palabra añadida directamente a la lista prohibida.');

    expect(ForbiddenWord::first())->word->toBe('maldición')
        ->and(ForbiddenWord::first()->status)->toBe('accept');
});

it('sends forbidden word for review if the user is not an admin', function () {
    loginAsUser();

    $this->post(route('forbidden-words.request'), [
        'word' => 'grosería'
    ])
        ->assertRedirect()
        ->assertSessionHas('status', 'Palabra enviada a los administradores para su revisión.');

    expect(ForbiddenWord::first())->word->toBe('grosería')
        ->and(ForbiddenWord::first()->status)->toBe('pending');
});

it('downloads the user PDF if it exists', function () {
    Storage::fake('public');

    $user = loginAsUser();
    $filePath = 'reports/Resumen_' . $user->name . '.pdf';
    Storage::disk('public')->put($filePath, 'PDF content');

    $fileName = 'Resumen_' . $user->name . '.pdf';

    $this->get(route('user.download.pdf'))
        ->assertDownload($fileName);
});

it('returns 404 if the user PDF is not ready', function () {
    loginAsUser();

    $this->get(route('user.download.pdf'))
        ->assertNotFound();
});
