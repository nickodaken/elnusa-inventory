<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);

        // User::factory(10)->create();

        // $role = Role::create(['name' => 'SuperAdmin']);

        // $permission = Permission::create(['name' => 'menu.user']);
        // $permission->assignRole($role);

        // $user = User::factory()->create([
        //     'name' => 'Administrator',
        //     'email' => 'admin@elnusa.com',
        //     'username' => 'admin',
        //     'password' => 'adminElnusa'
        // ]);

        // $user->assignRole('SuperAdmin');
    }
}
