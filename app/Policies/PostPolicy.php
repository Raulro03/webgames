<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    public function update(User $user, Post $post)
    {
        return ($user->hasRole('author') && $user->id === $post->user_id)
            || ($user->hasRole('moderator') && $user->id === $post->user_id);
    }

    public function delete(User $user, Post $post)
    {
        return ($user->hasRole('author') && $user->id === $post->user_id)
            || ($user->hasRole('moderator') && $post->comments()->count() === 0
                || $user->hasRole('moderator') && $user->id === $post->user_id);
    }

    public function restore(User $user, Post $post)
    {
        return ($user->hasRole('author') && $user->id === $post->user_id)
            || ($user->hasRole('moderator') && $user->id === $post->user_id);
    }

    public function forceDelete(User $user, Post $post)
    {
        return ($user->hasRole('author') && $user->id === $post->user_id)
            || ($user->hasRole('moderator') && $user->id === $post->user_id);
    }
}
