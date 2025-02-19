<?php

namespace App\Console\Commands;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdatePostStatus extends Command
{
    protected $signature = 'post:update-status';
    protected $description = 'Actualiza el estado de los posts después de un tiempo determinado';

    public function handle()
    {
        $posts = Post::all();

        foreach ($posts as $post) {
            if ($post->published_at > Carbon::now()) {
                $post->status = 'not_published';
            } elseif ($post->published_at <= Carbon::now() && $post->published_at > Carbon::now()->subYear()) {
                $post->status = 'published';
            } elseif ($post->published_at <= Carbon::now()->subYear()) {
                $post->status = 'archived';
            }
            $post->save();
        }

        $this->info("Se actualizaron los estados de los posts");
    }
}
