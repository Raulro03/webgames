<?php

namespace App\Listeners;

use App\Events\FirstPostCreatedEvent;
use App\Mail\FirstPostCreated;
use Illuminate\Support\Facades\Mail;

class SendFirstPostEmail
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
    public function handle(FirstPostCreatedEvent $event)
    {
        $user = $event->post->user;

        if ($user->posts()->count() === 1) {
            Mail::to($user->email)->send(new FirstPostCreated($event->post));
        }
    }
}
