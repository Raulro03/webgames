<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateUserToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-user-token {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar un token para el usuario con el email proporcionado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();

        if ($user) {
            $token = $user->createToken('Personal Access Token')->plainTextToken;
            $this->info("El token del usuario {$email} es: {$token}");
            file_put_contents(storage_path('app/tokens.txt'), "Most Recent {$email} Token: $token\n", FILE_APPEND);
        } else {
            $this->error("No se encontró un usuario con el email {$email}");
        }
    }
}
