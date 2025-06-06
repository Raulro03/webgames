<?php

namespace App\Policies;

use App\Models\Platform;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlatformPolicy
{
    use HandlesAuthorization;

    public function before(User $user, $ability)
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('moderator');
    }

    public function update(User $user, Platform $platform): bool
    {
        if ($user->hasRole('moderator')) {

            return $platform->release_date && $platform->release_date->lte(now()->subYear());
        }

        return false;
    }

    public function delete(User $user, Platform $platform): bool
    {
        if ($user->hasRole('moderator')) {
            return $platform->average_rating < 4 && $platform->release_date && $platform->release_date->lte(now()->subYear());
        }

        return false;
    }

}
