<?php

namespace App\Listeners;

use App\Events\PostDeletedEvent;
use App\Mail\PostDeletedMail;
use Illuminate\Support\Facades\Mail;

class SendPostDeletedEmail
{
    public function handle(PostDeletedEvent $event): void
    {
        $post = $event->post;
        $user = $post->user;

        if ($user && $user->email) {
            Mail::to($user->email)->send(new PostDeletedMail($post));
        }
    }
}
