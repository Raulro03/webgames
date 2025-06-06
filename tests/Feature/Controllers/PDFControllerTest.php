<?php

use App\Models\Developer;
use App\Models\Game;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\Platform;
use App\Jobs\GeneratePDFUserHistoryJob;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Barryvdh\DomPDF\Facade\Pdf;

it('downloads game PDF', function () {
    Storage::fake('public');

    loginAsUser();

    $file = UploadedFile::fake()->image('cover.jpg');
    $path = $file->store('games', 'public');

    $developer = Developer::factory()->create();
    $game = Game::factory()->create([
        'image_url' => $path,
        'developer_id' => $developer->id
    ]);

    $response = $this->get(route('game.pdf', $game->id));

    $response->assertOk();
    $response->assertHeader('content-disposition', 'attachment; filename=Juego_' . $game->title . '.pdf');
    expect($response->headers->get('content-type'))->toContain('application/pdf');
});

it('downloads platform PDF', function () {
    Storage::fake('public');

    loginAsUser();

    $file = UploadedFile::fake()->image('platform.jpg');
    $path = $file->store('platforms', 'public');

    $platform = Platform::factory()->create([
        'image_url' => $path,
    ]);

    $response = $this->get(route('platform.pdf', $platform->id));

    $response->assertOk();
    $response->assertHeader('content-disposition', 'attachment; filename="Plataforma_' . $platform->name . '.pdf"');
    expect($response->headers->get('content-type'))->toContain('application/pdf');
});


it('dispatches GeneratePDFUserHistoryJob and redirects back with status', function () {
    Bus::fake();

    $user = loginAsUser();

    $this->get(route('dashboard.pdf'))
        ->assertRedirect()
        ->assertSessionHas('status_pdf', 'El reporte se está generando. Estará disponible en breve.');

    Bus::assertDispatched(GeneratePDFUserHistoryJob::class, function ($job) use ($user) {
        return $job->getUser()->is($user);
    });
});
