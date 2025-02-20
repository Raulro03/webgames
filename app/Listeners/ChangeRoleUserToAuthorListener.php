<?php

namespace App\Listeners;

use App\Events\PostCreatedEvent;

class ChangeRoleUserToAuthorListener
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
        $user = $event->user;
        if ($user->roles->isEmpty()) {
            $user->assignRole('author');
            $user->save();
        }
    }
}
