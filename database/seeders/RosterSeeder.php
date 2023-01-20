<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator;

class RosterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rosters = \App\Models\Roster::factory(15)->create();
        foreach ($rosters as $roster) {
            $date = $roster->date->clone();
            if ($roster->type == 'DIVE') {
                for ($i = 0; $i < rand(1, 3); $i++) {
                    $cost = fake()->numberBetween(50, 90);
                    $price = $cost + ($cost * (10 / 100));
                    if ($i > 0)
                        $date = $date->addMinutes(75);
                    \App\Models\RosterDive::factory()->create(['roster_id' => $roster->id, 'cost' => $cost, 'price' => $price, 'date' => $date]);
                }
            } else
                \App\Models\RosterDive::factory()->create(['roster_id' => $roster->id, 'date' => $date]);
        }
    }
}
