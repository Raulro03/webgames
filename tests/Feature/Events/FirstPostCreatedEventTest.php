<?php

use App\Events\FirstPostCreatedEvent;
use App\Mail\FirstPostCreated;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Event;
use function Pest\Laravel\post;

it('dispatches FirstPostCreatedEvent when a post is created', function () {
    $this->seed();
    Event::fake();

    $user = User::query()->where('name', 'Normal User')->first();

    loginAsUser($user);

    $post = $user->posts()->create([
        'category_id' => 1,
        'title' => 'Nuevo Post',
        'body' => 'Contenido de prueba',
        'published_at' => now(),
        'status' => 'published',
    ]);


    if ($user->posts()->count() === 1) {
        event(new FirstPostCreatedEvent($post));
    }


    Event::assertDispatched(FirstPostCreatedEvent::class, function ($event) use ($post) {
        return $event->post->id === $post->id;
    });
});
it('sends an email when a user creates their first post', function () {
    $this->seed();
    Mail::fake();

    $user = User::query()->where('name', 'Normal User')->first();

    loginAsUser($user);

    $post = $user->posts()->create([
        'category_id' => 1,
        'title' => 'Nuevo Post',
        'body' => 'Contenido de prueba',
        'published_at' => now(),
        'status' => 'published',
    ]);

    if ($user->posts()->count() === 1) {
        event(new FirstPostCreatedEvent($post));
    }

    Mail::assertSent(FirstPostCreated::class, function ($mail) use ($post) {
        return $mail->post->id === $post->id;
    });
});
