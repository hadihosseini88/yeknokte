<?php

namespace Hadihosseini88\Course\Database\Seeds;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\Hadihosseini88\RolePermissions\Models\Permission::$permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        foreach (\Hadihosseini88\RolePermissions\Models\Role::$roles as $role => $permissions) {

            Role::findOrCreate($role)->givePermissionTo($permissions);
        }
    }
}
