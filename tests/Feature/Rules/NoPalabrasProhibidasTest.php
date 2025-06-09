<?php

use App\Models\ForbiddenWord;
use App\Rules\NoPalabrasProhibidas;


it('passes validation when no forbidden words are present', function () {

    ForbiddenWord::factory()->create(['word' => 'malo', 'status' => 'accept']);

    $rule = new NoPalabrasProhibidas();

    $failCalled = false;
    $rule->validate('description', 'Este texto está limpio', function ($message) use (&$failCalled) {
        $failCalled = true;
    });

    expect($failCalled)->toBeFalse();
});

it('fails validation when forbidden word is present', function () {
    ForbiddenWord::factory()->create(['word' => 'malo', 'status' => 'accept']);

    $rule = new NoPalabrasProhibidas();

    $failCalled = false;
    $rule->validate('description', 'Esto es malo', function ($message) use (&$failCalled) {
        $failCalled = true;
        expect($message)->toContain('description');
        expect($message)->toContain('palabras prohibidas');
    });

    expect($failCalled)->toBeTrue();
});

it('ignores forbidden words with different status', function () {
    ForbiddenWord::factory()->create(['word' => 'malo', 'status' => 'pending']);

    $rule = new NoPalabrasProhibidas();

    $failCalled = false;
    $rule->validate('description', 'Esto es malo', function ($message) use (&$failCalled) {
        $failCalled = true;
    });

    expect($failCalled)->toBeFalse();
});
