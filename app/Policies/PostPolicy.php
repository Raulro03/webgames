<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    public function update(User $user, Post $post)
    {
        return $user->hasPermissionTo('edit your posts') && $user->id === $post->user_id
            || $user->hasPermissionTo('edit any post');
    }

    public function delete(User $user, Post $post)
    {
        return $user->hasPermissionTo('delete your posts') && $user->id === $post->user_id
            || $user->hasPermissionTo('delete any post');
    }
}
