<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    public function update(User $user, Comment $comment)
    {
        return ($user->hasRole('author') && $user->id === $comment->user_id)
            || ($user->hasRole('moderator') && $user->id === $comment->user_id);
    }

    public function delete(User $user, Comment $comment)
    {
        return ($user->hasRole('author') && $user->id === $comment->user_id)
            || $user->hasRole('moderator');
    }
}
