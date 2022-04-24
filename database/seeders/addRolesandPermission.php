<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class addRolesandPermission extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = Role::create(['name' => 'Super Admin']);
        $user = User::find(1);
        $user->assignRole($role);
        $role = Role::create(['name' => 'Admin']);
        $user = User::find(2);
        $user->assignRole($role);
    }
}
