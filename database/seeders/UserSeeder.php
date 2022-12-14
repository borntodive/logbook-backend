<?php

namespace Database\Seeders;

use App\Models\Equipment;
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
        $users=\App\Models\User::factory(100)->create();
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
