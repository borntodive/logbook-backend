<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);

        $staffRole = Role::where('name', 'staff')->first();
        $userRole = Role::where('name', 'user')->first();


        $staffs = \App\Models\User::factory(15)->create([
            'cf' => 'CVLNDR84B18H501A',
            'user_duty_id' => 3,
        ]);
        foreach ($staffs as $staff) {
            $staff->attachRole($staffRole);
        }
        $users = \App\Models\User::factory(100)->create([
            'cf' => 'CVLNDR84B18H501A'
        ]);
        foreach ($users as $user) {
            $user->attachRole($userRole);
        }
        foreach (User::get() as $user) {
            $user->equipments()->detach();
            foreach (Equipment::get() as $eq) {
                $sizes = $eq->sizes;
                if ($eq->has_sizes) {
                    $size = $sizes->random();
                    $user->equipments()->attach($eq->id, ['size_id' => $size->id]);
                } else
                    $user->equipments()->attach($eq->id, ['number' => rand(0, 20)]);
            }
        }
    }
}
