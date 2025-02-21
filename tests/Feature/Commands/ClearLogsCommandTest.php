<?php
use function Pest\Laravel\artisan;
use Illuminate\Support\Facades\File;

it('clears logs from storage/logs', function () {

    $logPath = storage_path('logs');
    File::ensureDirectoryExists($logPath);
    File::put("$logPath/test.log", "Este es un log de prueba.");
    File::put("$logPath/error.log", "Otro log de prueba.");


    artisan('logs:clear')
        ->expectsOutput('Los logs se eliminaron correctamente.')
        ->assertExitCode(0);


    expect(File::files($logPath))->toBeEmpty();
});

it('shows a message when there are no logs', function () {

    $logPath = storage_path('logs');
    File::cleanDirectory($logPath);


    artisan('logs:clear')
        ->expectsOutput('No hay logs para eliminar.')
        ->assertExitCode(0);
});
