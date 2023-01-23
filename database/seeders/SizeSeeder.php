<?php

namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sizes = [
            [
                'name' => 'xxxs',
                'order' => 1
            ],
            [
                'name' => 'xxs',
                'order' => 2
            ],
            [
                'name' => 'xs',
                'order' => 3
            ],
            [
                'name' => 's',
                'order' => 4
            ],
            [
                'name' => 'm',
                'order' => 5
            ],
            [
                'name' => 'lg',
                'order' => 6
            ],
            [
                'name' => 'xl',
                'order' => 7
            ],
            [
                'name' => 'xxl',
                'order' => 8
            ],
            [
                'name' => 'uni',
                'order' => 999
            ],
            [
                'name' => '4L',
                'order' => 1
            ],
            [
                'name' => '5L',
                'order' => 2
            ],
            [
                'name' => '7L',
                'order' => 3
            ],
            [
                'name' => '10L',
                'order' => 4
            ],
            [
                'name' => '11L',
                'order' => 5
            ],
            [
                'name' => '12L',
                'order' => 6
            ],
            [
                'name' => '15L',
                'order' => 7
            ],
            [
                'name' => '18L',
                'order' => 8
            ],
            [
                'name' => 'B10L',
                'order' => 9
            ],
            [
                'name' => 'B12L',
                'order' => 10
            ],
            [
                'name' => 'OCTO',
                'order' => 1
            ],
            [
                'name' => 'HOGA',
                'order' => 2
            ],
            [
                'name' => '2REG',
                'order' => 3
            ],
            [
                'name' => '3P',
                'order' => 1
            ],
            [
                'name' => '4P',
                'order' => 2
            ],
            [
                'name' => '5P',
                'order' => 3
            ],
            [
                'name' => '6P',
                'order' => 4
            ],
            [
                'name' => 'xxxsm',
                'order' => 1
            ],
            [
                'name' => 'xxsm',
                'order' => 2
            ],
            [
                'name' => 'xsm',
                'order' => 3
            ],
            [
                'name' => 'sm',
                'order' => 4
            ],
            [
                'name' => 'mm',
                'order' => 5
            ],
            [
                'name' => 'lgm',
                'order' => 6
            ],
            [
                'name' => 'xlm',
                'order' => 7
            ],
            [
                'name' => 'xxlm',
                'order' => 8
            ],
            [
                'name' => 'xxxsf',
                'order' => 9
            ],
            [
                'name' => 'xxsf',
                'order' => 10
            ],
            [
                'name' => 'xsf',
                'order' => 11
            ],
            [
                'name' => 'sf',
                'order' => 12
            ],
            [
                'name' => 'mf',
                'order' => 13
            ],
            [
                'name' => 'lgf',
                'order' => 14
            ],
            [
                'name' => 'xlf',
                'order' => 15
            ],
            [
                'name' => 'xxlf',
                'order' => 16
            ],
            [
                'name' => '0.5',
                'order' => 1
            ],
            [
                'name' => '1',
                'order' => 2
            ],
            [
                'name' => '1.5',
                'order' => 3
            ],
            [
                'name' => '2',
                'order' => 4
            ],
            [
                'name' => '2.5',
                'order' => 5
            ],
            [
                'name' => '3',
                'order' => 6
            ],
            [
                'name' => '3.5',
                'order' => 7
            ],
            [
                'name' => '4',
                'order' => 8
            ],

        ];
        foreach ($sizes as $size) {
            Size::create($size);
        }
    }
}
