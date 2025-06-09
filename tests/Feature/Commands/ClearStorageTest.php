<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

it('clears images and reports directories except .gitignore', function () {
    // Prepara carpetas y archivos
    File::ensureDirectoryExists(storage_path('app/public/images'));
    File::put(storage_path('app/public/images/test.jpg'), 'fake image');
    File::put(storage_path('app/public/images/.gitignore'), '');

    File::ensureDirectoryExists(storage_path('app/public/reports'));
    File::put(storage_path('app/public/reports/report.pdf'), 'fake report');
    File::put(storage_path('app/public/reports/.gitignore'), '');

    // Subcarpeta con archivo dentro de images
    File::ensureDirectoryExists(storage_path('app/public/images/subfolder'));
    File::put(storage_path('app/public/images/subfolder/another.jpg'), 'another');

    $exitCode = Artisan::call('storage:clear-specific');
    $output = Artisan::output();

    expect($exitCode)->toBe(0);
    expect($output)->toContain('Contenido de');

    // .gitignore debe seguir existiendo
    expect(File::exists(storage_path('app/public/images/.gitignore')))->toBeTrue();
    expect(File::exists(storage_path('app/public/reports/.gitignore')))->toBeTrue();

    // Archivos que no son .gitignore deben desaparecer
    expect(File::exists(storage_path('app/public/images/test.jpg')))->toBeFalse();
    expect(File::exists(storage_path('app/public/reports/report.pdf')))->toBeFalse();

    // Subdirectorios borrados
    expect(File::exists(storage_path('app/public/images/subfolder')))->toBeFalse();
});

it('warns if directories do not exist', function () {
    // Asegura que las carpetas no existan
    File::deleteDirectory(storage_path('app/public/images'));
    File::deleteDirectory(storage_path('app/public/reports'));

    $exitCode = Artisan::call('storage:clear-specific');
    $output = Artisan::output();

    expect($exitCode)->toBe(0);
    expect($output)->toContain('no existe');
});
