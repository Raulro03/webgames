<?php

namespace App\Listeners;

use App\Events\CommentDeletedEvent;
use App\Mail\CommentDeletedMail;
use Illuminate\Support\Facades\Mail;

class SendCommentDeletedEmail
{
    public function handle(CommentDeletedEvent $event): void
    {
        $comment = $event->comment;
        $user = $comment->user;

        if ($user && $user->email) {
            Mail::to($user->email)->send(new CommentDeletedMail($comment));
        }
    }
}
