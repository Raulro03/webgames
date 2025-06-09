<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ClearCacheCommand extends Command
{
    protected $signature = 'app:cache-clear';

    protected $description = 'Limpiar la cache del proyecto';

    public function handle()
    {
        $this->call('cache:clear');
        $this->call('route:clear');
        $this->call('config:clear');
        $this->call('view:clear');
        $this->info('Todas las cachés han sido limpiadas.');
    }
}
