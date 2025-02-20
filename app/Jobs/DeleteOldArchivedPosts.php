<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class DeleteOldArchivedPosts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle()
    {
        // Obtener la fecha límite (5 años atrás desde hoy)
        $fiveYearsAgo = Carbon::now()->subYears(5);

        // Buscar los posts archivados que son más antiguos que la fecha límite
        $postsToDelete = Post::where('status', 'archived')
            ->where('published_at', '<', $fiveYearsAgo)
            ->get();

        // Eliminar los posts
        foreach ($postsToDelete as $post) {
            Log::info("Eliminando post archivado: " . $post->id . " - " . $post->title);
            $post->delete();
        }

        Log::info("Se eliminaron " . count($postsToDelete) . " posts archivados de más de 5 años.");
    }
}
