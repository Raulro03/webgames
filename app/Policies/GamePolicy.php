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

        return false;
    }

    public function create(User $user){

        return $user->hasRole('moderator');
    }

    public function update(User $user, Game $game): bool
    {

        if ($user->hasRole('moderator')) {

            if ($game->average_rating !== null && $game->average_rating >= 4.5) {
                return false;
            }

            if ($game->release_date && $game->release_date->diffInYears(now()) > 1) {
                return false;
            }

            return true;
        }

        return false;
    }

    public function delete(User $user, Game $game)
    {
        if ($user->hasRole('moderator')) {
            return $game->average_rating < 4;
        }

        return false;
    }

}
