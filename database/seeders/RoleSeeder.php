<?php

namespace Database\Seeders;

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
        $moderator = Role::create(['name' => 'moderator']);

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
        $moderator->givePermissionTo(['edit your posts', 'delete your posts', 'edit your comments', 'delete your comments', 'manage games', 'manage platforms', 'manage character', 'delete any post', 'delete any comment']);
        $admin->givePermissionTo(Permission::all());
    }
}
