<?php

namespace App\Mail;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CommentDeletedMail extends Mailable
{
    use Queueable, SerializesModels;

    public Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Tu comentario ha sido eliminado',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.comment-deleted',
            with: [
                'comment' => $this->comment
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
