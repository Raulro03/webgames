<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class CreateUserAdminCommand extends Command
{
    protected $signature = 'app:create-admin {email} {--name=} {--password=}';

    protected $description = 'Crea un usuario con rol de administrador desde la consola';

    public function handle()
    {
        $email = $this->argument('email');
        $name = $this->option('name') ?? 'Admin';
        $password = $this->option('password') ?? 'password';

        $user = User::where('email', $email)->first();

        if ($user) {
            if ($user->hasRole('admin')) {
                $this->warn("El usuario {$email} ya tiene el rol 'admin'.");
                return;
            }

            $user->assignRole('admin');
            $this->info("Rol 'admin' asignado al usuario existente: {$email}");
            return;
        }

        // Crear usuario nuevo y asignar rol admin
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        // Asegurar que el rol exista
        Role::findOrCreate('admin');

        $user->assignRole('admin');

        $this->info("Usuario administrador creado: {$user->email}");
    }
}
