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
                'name' => 'view_all_users',
                'roles' => [$admin, $staff]
            ],
            [
                'name' => 'edit_users_role',
                'roles' => [$admin]
            ],
            [
                'name' => 'edit_users',
                'roles' => [$admin, $staff]
            ],
            [
                'name' => 'create_user',
                'roles' => [$admin, $staff]
            ],
            [
                'name' => 'delete_user',
                'roles' => [$admin]
            ],
            [
                'name' => 'edit_equipment',
                'roles' => [$admin, $staff]
            ],
            [
                'name' => 'view_all_courses',
                'roles' => [$admin, $staff]
            ],
            [
                'name' => 'create_course',
                'roles' => [$admin, $staff]
            ],
            [
                'name' => 'edit_course',
                'roles' => [$admin, $staff]
            ],
            [
                'name' => 'delete_course',
                'roles' => [$admin]
            ],
            [
                'name' => 'view_course_costs',
                'roles' => [$admin]
            ],
            [
                'name' => 'edit_settings',
                'roles' => [$admin]
            ],
            [
                'name' => 'view_price_list',
                'roles' => [$admin, $staff]
            ],
            [
                'name' => 'view-all-rosters',
                'roles' => [$admin, $staff]
            ],
        ];
        foreach ($permissions as $permission) {
            $p = Permission::firstOrCreate([
                'name' => $permission['name'],
                'display_name' => ucwords(str_replace('_', ' ', $permission['name'])),
                'description' => ucwords(str_replace('_', ' ', $permission['name'])),
            ]);
            foreach ($permission['roles'] as $role) {
                $role->attachPermission($p);
            }
        }
    }
}
