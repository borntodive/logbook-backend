<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole=Role::where('name','admin')->first();
        $staffRole=Role::where('name','staff')->first();
        $userRole=Role::where('name','user')->first();
        $andrea=\App\Models\User::factory()->create([
            'cf'=>'CVLNDR84B18H501A',
            'firstname'=>'Andrea',
            'lastname' => 'Covelli',
            'gender'=>'male',
            'email' => 'andrea.covelli@gmail.com',
            'user_duty_id'=> 3,

        ]);
        $andrea->attachRole($adminRole);
         $davide=\App\Models\User::factory()->create([
            'cf'=>'CVLNDR84B18H501A',
            'firstname'=>'Davide',
            'lastname' => 'Bastiani',
            'gender'=>'male',
            'email' => 'davide@toponediving.it',
            'user_duty_id'=> 3,

        ]);
        $davide->attachRole($adminRole);

        $staffs=\App\Models\User::factory(15)->create([
            'cf'=>'CVLNDR84B18H501A',
            'user_duty_id'=> 3,
        ]);
        foreach($staffs as $staff) {
                    $staff->attachRole($staffRole);

        }
        $users=\App\Models\User::factory(100)->create([
            'cf'=>'CVLNDR84B18H501A'
        ]);
        foreach($users as $user) {
                    $user->attachRole($userRole);

        }
        foreach (User::get() as $user){
            foreach (Equipment::get() as $eq) {
                $sizes=$eq->sizes;
                if (count($sizes))
                {
                    $size = $sizes->random();
                $user->equipments()->attach($eq->id,['size_id'=>$size->id]);
                }
                else
                $user->equipments()->attach($eq->id,['number'=>rand(0, 20)]);
            }
        }
    }
}
