<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\PostCreatedEvent;
use App\Events\CommentCreateEvent;
use App\Listeners\ChangeRoleUserToAuthorListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PostCreatedEvent::class => [
            ChangeRoleUserToAuthorListener::class,
        ],
        CommentCreateEvent::class => [
            ChangeRoleUserToAuthorListener::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}
