<?php

namespace App\Listeners;

use App\Events\PostCreatedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Artisan;

class RunUpdatePostStatus
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(PostCreatedEvent $event)
    {

        Artisan::call('post:update-status');

        \Log::info("Command ejecutado para actualizar status de posts");
    }
}
