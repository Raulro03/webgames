<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CommentPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Comment $comment)
    {
        return $user->hasPermissionTo('edit your comments') && $user->id === $comment->user_id
            || $user->hasPermissionTo('edit any comment');
    }

    public function delete(User $user, Comment $comment)
    {
        return $user->hasPermissionTo('delete your comments') && $user->id === $comment->user_id
            || $user->hasPermissionTo('delete any comment');
    }
}
