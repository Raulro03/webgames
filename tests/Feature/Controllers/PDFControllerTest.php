<?php

use App\Models\Character;
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

it('downloads the top 5 characters PDF with correct headers and content', function () {
    loginAsUser();

    // Crea varios personajes con estadísticas y juegos para asegurar que hay datos que listar
    $characters = Character::factory(6)->create()->each(function ($character) {
        $character->statistics()->create([
            'constitution' => rand(1, 10),
            'strength' => rand(1, 10),
            'agility' => rand(1, 10),
            'intelligence' => rand(1, 10),
            'charisma' => rand(1, 10),
        ]);
        // Asocia juegos opcionales (creados aquí rápido)
        $game = CreateGameWithDeveloper();
        $character->games()->attach($game->id, ['appearance' => now()->toDateString()]);
    });

    // Mockeamos Pdf para interceptar la generación y ver que se llama correctamente
    Pdf::shouldReceive('loadView')
        ->once()
        ->with('pdf.character_summary_top5', \Mockery::on(function ($data) use ($characters) {
            // Comprobar que topCharacters es un collection con máximo 5 items
            return $data['topCharacters'] instanceof \Illuminate\Support\Collection
                && $data['topCharacters']->count() <= 5;
        }))
        ->andReturnSelf();

    Pdf::shouldReceive('download')
        ->once()
        ->with('Top_5_Personajes.pdf')
        ->andReturn(response('fake-pdf-content', 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename=Top_5_Personajes.pdf',
        ]));

    // Ejecuta la ruta o acción que hace la descarga
    $response = $this->get(route('characters.pdf'));

    $response->assertOk();
    $response->assertHeader('content-type', 'application/pdf');
    $response->assertHeader('content-disposition', 'attachment; filename=Top_5_Personajes.pdf');
});
