<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearStorage extends Command
{
    protected $signature = 'storage:clear-specific';

    protected $description = 'Borra todo dentro de storage/app/images y storage/app/reports excepto .gitignore';

    public function handle()
    {
        $pathsToClear = [
            storage_path('\app\public\images'),
            storage_path('\app\public\reports'),
        ];

        foreach ($pathsToClear as $path) {
            if (!File::exists($path)) {
                $this->warn("La carpeta $path no existe. Se omite.");
                continue;
            }

            // Borra archivos excepto .gitignore
            $files = File::files($path);
            foreach ($files as $file) {
                if ($file->getFilename() !== '.gitignore') {
                    File::delete($file->getPathname());
                }
            }

            // Borra subdirectorios completos
            $dirs = File::directories($path);
            foreach ($dirs as $dir) {
                File::deleteDirectory($dir);
            }

            $this->info("Contenido de $path borrado excepto .gitignore.");
        }

        return 0;
    }
}
