<?php

use App\Jobs\DeleteOldArchivedPosts;
use Illuminate\Support\Facades\Queue;
use function Pest\Laravel\artisan;

it('dispatches the DeleteOldArchivedPosts job', function () {
    // 🔹 Simular la cola de trabajos
    Queue::fake();

    // 🔹 Ejecutar el comando
    artisan('posts:delete-old-archived-posts')
        ->expectsOutput('El Job para eliminar posts antiguos ha sido enviado a la cola.')
        ->assertExitCode(0);

    // 🔹 Verificar que el Job fue enviado a la cola
    Queue::assertPushed(DeleteOldArchivedPosts::class);
});
