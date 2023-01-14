<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $equipments = [
            [
                'name' => 'suit',
                'order' => 3,
                'sizes' => [
                    'xxs',
                    'xs',
                    's',
                    'm',
                    'lg',
                    'xl',
                    'xxl'
                ]
            ],

            [
                'name' => 'bcd',
                'order' => 1,

                'sizes' => [
                    'xxs',
                    'xs',
                    's',
                    'm',
                    'lg',
                    'xl',
                    'xxl'
                ]
            ],
            [
                'name' => 'boot',
                'order' => 5,

                'sizes' => [
                    'xxs',
                    'xs',
                    's',
                    'm',
                    'lg',
                    'xl',
                    'xxl'
                ]
            ],
            [
                'name' => 'fins',
                'order' => 6,

                'sizes' => [
                    'xxs',
                    'xs',
                    's',
                    'm',
                    'lg',
                    'xl',
                    'xxl'
                ]
            ],
            [
                'name' => 'mask',
                'order' => 4,

                'sizes' => [
                    'uni',

                ]
            ],
            [
                'name' => 'weightsBelt',
                'order' => 7,

                'sizes' => [
                    'uni',

                ]
            ],
            [
                'name' => 'regulator',
                'order' => 2,

                'sizes' => [
                    'uni',

                ]
            ],
            [
                'name' => 'weight',
                'order' => 8,

                'sizes' => []
            ],
            [
                'name' => 'tank',
                'order' => 9,

                'sizes' => [
                    '4L',
                    '7L',
                    '10L',
                    '11L',
                    '12L',
                    '15L',
                    'B10L',
                    'B12L',

                ]
            ]
        ];
        foreach ($equipments as $equipment) {
            $eq = Equipment::create(['name' => $equipment['name'], 'order' => $equipment['order']]);
            foreach ($equipment['sizes'] as $size) {
                $s = Size::where('name', $size)->first();
                $eq->sizes()->attach($s);
            }
        }
    }
}
