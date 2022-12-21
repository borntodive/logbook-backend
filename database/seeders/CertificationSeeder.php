<?php

namespace Database\Seeders;

use App\Models\Certification;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $certifications = [
            [
                "name"=>"Open Water Diver",
                "code"=>"OWD",
                'cost'=>50.50,
                "price"=>350

            ],
            [
                "name"=>"Advanced Open Water Diver",
                "code"=>"AOWD",
                'cost'=>50.50,
                "price"=>200
            ]
        ];
        foreach($certifications as $certification) {
            Certification::create($certification);
        }
    }
}
