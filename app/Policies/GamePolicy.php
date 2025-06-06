<?php

namespace App\Policies;

use App\Models\Game;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GamePolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    public function create(User $user){

        return $user->hasRole('moderator');
    }

    public function update(User $user, Game $game): bool
    {

        if ($user->hasRole('moderator')) {

            return $game->release_date && $game->release_date->lte(now()->subYear());
        }

        return false;
    }

    public function delete(User $user, Game $game)
    {
        if ($user->hasRole('moderator')) {
            return $game->average_rating < 4 && $game->release_date && $game->release_date->lte(now()->subYear());
        }

        return false;
    }

}
