<?php

namespace App\Providers;

use App\Actions\Jetstream\DeleteUser;
use App\Models\Character;
use App\Models\Comment;
use App\Models\Game;
use App\Models\Platform;
use App\Models\Post;
use App\Policies\CharacterPolicy;
use App\Policies\CommentPolicy;
use App\Policies\GamePolicy;
use App\Policies\PlatformPolicy;
use App\Policies\PostPolicy;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Laravel\Jetstream\Jetstream;

class JetstreamServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(Comment::class, CommentPolicy::class);
        Gate::policy(Game::class, GamePolicy::class);
        Gate::policy(Platform::class, PlatformPolicy::class);
        Gate::policy(Character::class, CharacterPolicy::class);

        $this->configurePermissions();

        Jetstream::deleteUsersUsing(DeleteUser::class);

        Vite::prefetch(concurrency: 3);

    }

    /**
     * Configure the permissions that are available within the application.
     */
    protected function configurePermissions(): void
    {
        Jetstream::defaultApiTokenPermissions(['read']);

        Jetstream::permissions([
            'create',
            'read',
            'update',
            'delete',
        ]);
    }
}
