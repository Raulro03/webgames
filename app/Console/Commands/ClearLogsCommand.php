<?php

namespace App\Console\Commands;
use File;
use Illuminate\Console\Command;
class ClearLogsCommand extends Command
{
    protected $signature = 'logs:clear';

    protected $description = 'Eliminar los logs almacenados en storage/logs';

    public function handle()
    {
        $logPath = storage_path('logs');

        $logFiles = File::files($logPath);

        if (empty($logFiles)) {
            $this->info('No hay logs para eliminar.');
            return;
        }

        foreach ($logFiles as $file) {
            File::delete($file);
        }

        $this->info('Los logs se eliminaron correctamente.');
    }
}
