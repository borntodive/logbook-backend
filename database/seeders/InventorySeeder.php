<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Inventory;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class InventorySeeder extends Seeder
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
                'types' => [
                    [
                        'name' => 'pool',
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
                        'name' => 'dive',
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
                        'name' => 'dry',
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
                ]
            ],

            [
                'name' => 'bcd',
                'order' => 1,

                'types' => [
                    [
                        'name' => 'recreational',
                        'sizes' => [
                            'xxxs',
                            'xxs',
                            'xs',
                            's',
                            'm',
                            'lg',
                            'xl',
                            'xxl',
                        ]
                    ],
                    [
                        'name' => 'technical',
                        'sizes' => [
                            'uni'
                        ]
                    ],
                ]
            ],
            [
                'name' => 'boot',
                'order' => 5,

                'types' => [
                    [
                        'name' => 'recreational',
                        'sizes' => [
                            'xxxs',
                            'xxs',
                            'xs',
                            's',
                            'm',
                            'lg',
                            'xl',
                            'xxl',
                        ]
                    ],
                ]
            ],
            [
                'name' => 'fins',
                'order' => 6,

                'types' => [
                    [
                        'name' => 'strap',
                        'sizes' => [
                            'xxxs',
                            'xxs',
                            'xs',
                            's',
                            'm',
                            'lg',
                            'xl',
                            'xxl',
                        ]
                    ],
                    [
                        'name' => 'footpoket',
                        'sizes' => [
                            'xxxs',
                            'xxs',
                            'xs',
                            's',
                            'm',
                            'lg',
                            'xl',
                            'xxl',
                        ]
                    ],
                ]
            ],
            [
                'name' => 'mask',
                'order' => 4,

                'types' => [
                    [
                        'name' => 'recreational',
                        'sizes' => [
                            'uni',
                        ]
                    ],

                ]
            ],
            [
                'name' => 'weightsBelt',
                'order' => 7,

                'types' => [
                    [
                        'name' => 'classic',
                        'sizes' => [
                            'uni',
                        ]
                    ],
                    [
                        'name' => 'pockets',
                        'sizes' => [
                            '3P',
                            '4P',
                            '5P',
                            '6P',
                        ]
                    ],

                ]
            ],
            [
                'name' => 'regulator',
                'order' => 2,

                'types' => [
                    [
                        'name' => 'recreational',
                        'sizes' => [
                            'OCTO',
                            '2REG'
                        ]
                    ],
                    [
                        'name' => 'technical',
                        'sizes' => [
                            'HOGA',
                        ]
                    ],

                ]
            ],
            [
                'name' => 'weight',
                'order' => 8,
                'has_sizes' => false,
                'types' => [
                    [
                        'name' => 'recreational',
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
                ]
            ],
            [
                'name' => 'tank',
                'order' => 9,

                'types' => [
                    [
                        'name' => 'aluminum',
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
                    ],
                    [
                        'name' => 'iron',
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
                    ],
                ]
            ]
        ];
        foreach ($equipments as $equipment) {

            $eq = Equipment::where('name', $equipment['name'])->first();
            if (!isset($eq->id))
                dd($equipment['name']);
            foreach ($equipment['types']  as $type) {
                $t = EquipmentType::where('name', $type['name'])->first();
                if (!isset($t->id))
                    dd($type['name']);
                foreach ($type['sizes'] as $size) {
                    $s =
                        Size::where('name', $size)->first();
                    if (!isset($s->id))
                        dd($size);
                    $items = [];
                    if (!App::environment('production')) {
                        for ($i = 0; $i < rand(0, 10); $i++) {
                            $items[] = [
                                'code'      => Str::uuid(),
                                'available' => random_int(0, 100) < 40,
                            ];
                        }
                    }
                    Inventory::create(['equipment_id' => $eq->id, 'equipment_type_id' => $t->id, 'size_id' => $s->id, 'items' => $items]);
                }
            }
        }
    }
}
