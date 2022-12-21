<?php

namespace Database\Seeders;

use App\Models\Certification;
use App\Models\UserDuty;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserDutySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $duties=[
            'Diver',
            'Divemaster',
            'Instructor',
        ];
        foreach($duties as $duty) {
            UserDuty::create(['name'=>$duty]);
        }
    }
}
