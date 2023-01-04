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

        include_once('certifications.php');

        foreach ($certifications as $certification) {
            if (isset($certification['activities_old'])) unset($certification['activities_old']);
            Certification::create($certification);
        }
    }
}
