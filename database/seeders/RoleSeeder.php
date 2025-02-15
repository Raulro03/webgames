<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $admin = Role::create(['name' => 'admin']);
        $author = Role::create(['name' => 'author']);
        $user = Role::create(['name' => 'user']);

        Permission::create(['name' => 'edit your posts']);
        Permission::create(['name' => 'delete your posts']);
        Permission::create(['name' => 'edit your comments']);
        Permission::create(['name' => 'delete your comments']);
        Permission::create(['name' => 'manage users']);
        Permission::create(['name' => 'manage games']);
        Permission::create(['name' => 'manage platforms']);
        Permission::create(['name' => 'manage character']);
        Permission::create(['name' => 'delete any post']);
        Permission::create(['name' => 'edit any post']);
        Permission::create(['name' => 'delete any comment']);
        Permission::create(['name' => 'edit any comment']);

        $author->givePermissionTo([ 'edit your posts', 'delete your posts', 'edit your comments', 'delete your comments']);
        $admin->givePermissionTo(Permission::all());
    }
}
