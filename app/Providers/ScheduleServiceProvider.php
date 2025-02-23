<?php

namespace App\Providers;

use App\Jobs\CleanTrashedPosts;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->job(new CleanTrashedPosts())->monthly();
            $schedule->command('logs:clear')->weekly();
            $schedule->command('posts:delete-old-archived-posts')->weekly();
        });
    }
}
