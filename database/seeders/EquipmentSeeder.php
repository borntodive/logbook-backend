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
                    'xxxsm',
                    'xxsm',
                    'xsm',
                    'sm',
                    'mm',
                    'lgm',
                    'xlm',
                    'xxlm',
                    'xxxsf',
                    'xxsf',
                    'xsf',
                    'sf',
                    'mf',
                    'lgf',
                    'xlf',
                    'xxlf',
                ]
            ],

            [
                'name' => 'bcd',
                'order' => 1,

                'sizes' => [
                    'xxxs',
                    'xxs',
                    'xs',
                    's',
                    'm',
                    'lg',
                    'xl',
                    'xxl',
                    'uni'
                ]
            ],
            [
                'name' => 'boot',
                'order' => 5,

                'sizes' => [
                    'xxxs',
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
                    'xxxs',
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
                    '3P',
                    '4P',
                    '5P',
                    '6P',

                ]
            ],
            [
                'name' => 'regulator',
                'order' => 2,

                'sizes' => [
                    'OCTO',
                    'HOGA',

                ]
            ],
            [
                'name' => 'weight',
                'order' => 8,
                'has_sizes' => false,
                'sizes' => [
                    '0.5',
                    '1',
                    '1.5',
                    '2',
                    '2.5',
                    '3',
                    '3.5',
                    '4'
                ]
            ],
            [
                'name' => 'tank',
                'order' => 9,

                'sizes' => [
                    '4L',
                    '5L',
                    '7L',
                    '10L',
                    '11L',
                    '12L',
                    '15L',
                    '18L',
                    'B10L',
                    'B12L',

                ]
            ]
        ];
        foreach ($equipments as $equipment) {
            $sizes = $equipment['sizes'];
            unset($equipment['sizes']);
            $eq = Equipment::create($equipment);
            foreach ($sizes  as $size) {
                $s = Size::where('name', $size)->first();
                $eq->sizes()->attach($s);
            }
        }
    }
}
