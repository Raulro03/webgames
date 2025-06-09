<?php

namespace App\Jobs;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ScanContentForNewForbiddenWordJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $word;

    public function __construct(string $word)
    {
        $this->word = strtolower($word);
    }

    public function handle()
    {


        Comment::whereRaw('LOWER(body) LIKE ?', ['%' . $this->word . '%'])
            ->delete();

        Post::where('status', '!=', 'archived')
            ->whereRaw('LOWER(body) LIKE ?', ['%' . $this->word . '%'])
            ->update(['status' => 'archived']);


    }
}
