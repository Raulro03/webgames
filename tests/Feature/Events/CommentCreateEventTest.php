<?php
use App\Events\CommentCreateEvent;
use App\Listeners\ChangeRoleUserToAuthorListener;
use App\Models\User;
use Illuminate\Support\Facades\Event;

it('dispatches the CommentCreateEvent', function () {
    Event::fake();

    $user = User::factory()->create();

    event(new CommentCreateEvent($user));

    Event::assertDispatched(CommentCreateEvent::class, function ($event) use ($user) {
        return $event->user->is($user);
    });

});

it('when executed this event executed listeners too', function () {
    Event::fake();

    $user = User::factory()->create();

    event(new CommentCreateEvent($user));


    Event::assertDispatched(CommentCreateEvent::class);


    Event::assertListening(CommentCreateEvent::class, ChangeRoleUserToAuthorListener::class);

});
