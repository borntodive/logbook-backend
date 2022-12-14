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
        $sizes=[
            'xxs',
            'xs',
            's',
            'm',
            'lg',
            'xl',
            'xxl',
            'uni',
            '4L',
            '7L',
            '10L',
            '11L',
            '12L',
            '15L',
            '10+10L',
            '12+12L',

        ];
        foreach($sizes as $size) {
            Size::create(['name'=>$size]);
        }
    }
}
