<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        foreach (Permission::$permissions as $permission){
            Permission::findOrCreate($permission, 'api');
        }

        foreach (Role::$roles as $role => $permission){
            Role::findOrCreate($role, 'api')->givePermissionTo($permission);
        }
    }
}
