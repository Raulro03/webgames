<?php

use App\Jobs\DeleteOldArchivedPosts;
use Illuminate\Support\Facades\Queue;
use function Pest\Laravel\artisan;

it('dispatches the DeleteOldArchivedPosts job', function () {

    Queue::fake();


    artisan('posts:delete-old-archived-posts')
        ->expectsOutput('El Job para eliminar posts antiguos ha sido enviado a la cola.')
        ->assertExitCode(0);


    Queue::assertPushed(DeleteOldArchivedPosts::class);
});
