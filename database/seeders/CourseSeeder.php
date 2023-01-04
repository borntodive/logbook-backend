<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Course::factory()->create(['certification_id' => 1, 'specialities' => [6, 7, 8, 9]]);
        \App\Models\Course::factory()->create(['certification_id' => 5]);
        // \App\Models\Course::factory(20)->create();
    }
}
