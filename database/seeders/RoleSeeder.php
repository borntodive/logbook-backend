<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = Role::create([
            'name' => 'admin',
            'display_name' => 'Admin', // optional
        ]);
        $staff = Role::create([
            'name' => 'staff',
            'display_name' => 'Staff', // optional
        ]);
        $user = Role::create([
            'name' => 'user',
            'display_name' => 'User', // optional
        ]);

        $permissions = [
            [
                'name' => 'view-costs',
                'roles' => [$admin]
            ],
            [
                'name' => 'view-all',
                'roles' => [$admin, $staff]
            ],
            [
                'name' => 'edit-all',
                'roles' => [$admin, $staff]
            ],
            [
                'name' => 'delete-all',
                'roles' => [$admin]
            ],
        ];
        foreach ($permissions as $permission) {
            $p = Permission::firstOrCreate([
                'name' => $permission['name'],
                'display_name' => ucwords(str_replace('-', ' ', $permission['name'])),
                'description' => ucwords(str_replace('-', ' ', $permission['name'])),
            ]);
            foreach ($permission['roles'] as $role) {
                $role->attachPermission($p);
            }
        }
    }
}
