<?php

use App\Events\PostCreatedEvent;
use App\Listeners\ChangeRoleUserToAuthorListener;
use App\Listeners\RunUpdatePostStatus;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use function Pest\Laravel\post;

it('dispatches PostCreatedEvent when a user creates a post', function () {
    Event::fake();
    CreateUser_ForumCategory();

    $user = User::factory()->create();
    loginAsUser($user);

    $user->posts()->create([
        'category_id' => 1,
        'title' => 'Nuevo Post',
        'body' => 'Contenido de prueba',
        'published_at' => now(),
        'status' => 'published',
    ]);

    event(new PostCreatedEvent(auth()->user()));

    Event::assertDispatched(PostCreatedEvent::class, function ($event) use ($user) {
        return $event->user->id === $user->id;
    });
});

it('when executed this event executed listeners too', function () {
    Event::fake();

    $user = User::factory()->create();

    event(new PostCreatedEvent($user));


    Event::assertDispatched(PostCreatedEvent::class);


    Event::assertListening(PostCreatedEvent::class, ChangeRoleUserToAuthorListener::class);
    Event::assertListening(PostCreatedEvent::class, RunUpdatePostStatus::class);
});
