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
        $equipments=[
             [
            'name'=> 'suit',
            'sizes'=>[
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
            'name'=> 'bcd',
            'sizes'=>[
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
            'name'=> 'boot',
            'sizes'=>[
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
            'name'=> 'fins',
            'sizes'=>[
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
            'name'=> 'mask',
            'sizes'=>[
                'uni',

            ]
        ],
        [
            'name'=> 'weightsBelt',
            'sizes'=>[
                'uni',

            ]
        ],
        [
            'name'=> 'regulator',
            'sizes'=>[
                'uni',

            ]
        ],
[
            'name'=> 'weight',
            'sizes'=>[

            ]
        ],
        [
            'name'=> 'tank',
            'sizes'=>[
                '4L',
                '7L',
            '10L',
            '11L',
            '12L',
            '15L',
            '10+10L',
            '12+12L',

            ]
        ]
        ];
        foreach($equipments as $equipment) {
            $eq=Equipment::create(['name'=>$equipment['name']]);
            foreach ($equipment['sizes'] as $size){
                $s=Size::where('name',$size)->first();
                $eq->sizes()->attach($s);
            }
        }
    }
}
