<?php

namespace App\Console\Commands;

use App\Models\Post;
use Illuminate\Console\Command;

class UpdatePostStatus extends Command
{
    protected $signature = 'post:update-status';
    protected $description = 'Actualiza el estado de los posts después de un tiempo determinado';

    public function handle()
    {

        Post::notPublished()->update(['status' => 'not_published']);
        Post::published()->update(['status' => 'published']);
        Post::archived()->update(['status' => 'archived']);

        $this->info("Se actualizaron los estados de los posts");
    }
}
