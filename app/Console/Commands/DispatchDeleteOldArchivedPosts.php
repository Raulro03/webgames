<?php

namespace App\Console\Commands;

use App\Jobs\DeleteOldArchivedPosts;
use Illuminate\Console\Command;

class DispatchDeleteOldArchivedPosts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'posts:delete-old-archived-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete posts that are archived and older than 5 years.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DeleteOldArchivedPosts::dispatch();

        $this->info('El Job para eliminar posts antiguos ha sido enviado a la cola.');
    }
}
