<?php

namespace App\Listeners;

use App\Events\PostCreated;
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
        if ($user->hasRole('user')) {
            $user->removeRole('user');
            $user->assignRole('author');
            $user->save();
        }
    }
}
