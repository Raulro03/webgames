<?php

use function Pest\Laravel\artisan;

it('puede limpiar todas las cachés sin errores', function () {
    artisan('app:cache-clear')
        ->assertExitCode(0)
        ->expectsOutput('Todas las cachés han sido limpiadas.');
});
