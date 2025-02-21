<?php
use App\Console\Commands\UpdatePostStatus;
use App\Models\Post;
use Carbon\Carbon;
use function Pest\Laravel\artisan;

it('updates post statuses correctly', function () {
    CreateUser_ForumCategory();
    // 🔹 Crear posts de prueba
    $futurePost = Post::factory()->create([
        'user_id' => 1,
        'category_id' => 1,
        'published_at' => Carbon::now()->addDays(10),
        'status' => 'not_published',
    ]);

    $recentPost = Post::factory()->create([
        'user_id' => 1,
        'category_id' => 1,
        'published_at' => Carbon::now()->subMonths(6),
        'status' => 'not_published',
    ]);

    $oldPost = Post::factory()->create([
        'user_id' => 1,
        'category_id' => 1,
        'published_at' => Carbon::now()->subYears(2),
        'status' => 'not_published',
    ]);

    // 🔹 Ejecutar el comando
    artisan('post:update-status')
        ->expectsOutput('Se actualizaron los estados de los posts')
        ->assertExitCode(0);

    // 🔹 Verificar los estados de los posts después del comando
    expect($futurePost->fresh()->status)->toBe('not_published');
    expect($recentPost->fresh()->status)->toBe('published');
    expect($oldPost->fresh()->status)->toBe('archived');
});

/*it('has commands\updatepoststatus page', function () {
    $response = $this->get('/commands\updatepoststatus');

    $response->assertStatus(200);
});*/
