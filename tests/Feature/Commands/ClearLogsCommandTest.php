<?php
use function Pest\Laravel\artisan;
use Illuminate\Support\Facades\File;

it('clears logs from storage/logs', function () {
    // 🔹 Crear logs falsos para la prueba
    $logPath = storage_path('logs');
    File::ensureDirectoryExists($logPath);
    File::put("$logPath/test.log", "Este es un log de prueba.");
    File::put("$logPath/error.log", "Otro log de prueba.");

    // 🔹 Ejecutar el comando Artisan
    artisan('logs:clear')
        ->expectsOutput('Los logs se eliminaron correctamente.')
        ->assertExitCode(0);

    // 🔹 Verificar que los archivos se eliminaron
    expect(File::files($logPath))->toBeEmpty();
});

it('shows a message when there are no logs', function () {
    // 🔹 Asegurar que la carpeta de logs esté vacía
    $logPath = storage_path('logs');
    File::cleanDirectory($logPath);

    // 🔹 Ejecutar el comando
    artisan('logs:clear')
        ->expectsOutput('No hay logs para eliminar.')
        ->assertExitCode(0);
});
