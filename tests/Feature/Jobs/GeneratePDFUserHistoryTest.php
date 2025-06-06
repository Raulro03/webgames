<?php

use App\Jobs\GeneratePDFUserHistoryJob;

it('generates and stores the user PDF report', function () {
    Storage::fake('public');

    $post = CreateUserAuth_Post();
    $user = $post->user;

    $job = new GeneratePDFUserHistoryJob($user);
    $job->handle();

    $expectedFilename = 'reports/Resumen_' . $user->name . '.pdf';

    Storage::disk('public')->assertExists($expectedFilename);
});
