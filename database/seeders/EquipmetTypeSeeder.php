<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmetTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => 'recreational',
                'order' => 1
            ],
            [
                'name' => 'technical',
                'order' => 2
            ],
            [
                'name' => 'pool',
                'order' => 1
            ],
            [
                'name' => 'dive',
                'order' => 2
            ],
            [
                'name' => 'dry',
                'order' => 3
            ],
            [
                'name' => 'strap',
                'order' => 1
            ],
            [
                'name' => 'footpoket',
                'order' => 2
            ],
            [
                'name' => 'classic',
                'order' => 1
            ],
            [
                'name' => 'pockets',
                'order' => 2
            ],
            [
                'name' => 'aluminum',
                'order' => 1
            ],
            [
                'name' => 'iron',
                'order' => 2
            ],


        ];
        foreach ($types as $type) {
            EquipmentType::create($type);
        }
    }
}
