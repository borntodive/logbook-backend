<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator;

class BaseUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = app(Generator::class);

        $adminRole = Role::where('name', 'admin')->first();

        $andrea = \App\Models\User::factory()->create([
            'cf' => 'CVLNDR84B18H501A',
            'firstname' => 'Andrea',
            'lastname' => 'Covelli',
            'gender' => 'male',
            'email' => 'andrea.covelli@gmail.com',
            'user_duty_id' => 3,
            'ssi_number' => $faker->numerify('#######')


        ]);
        $andrea->attachRole($adminRole);
        $davide = \App\Models\User::factory()->create([
            'cf' => 'CVLNDR84B18H501A',
            'firstname' => 'Davide',
            'lastname' => 'Bastiani',
            'gender' => 'male',
            'email' => 'davide@toponediving.it',
            'user_duty_id' => 3,
            'ssi_number' => $faker->numerify('#######')


        ]);
        $davide->attachRole($adminRole);

        foreach (User::get() as $user) {
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
