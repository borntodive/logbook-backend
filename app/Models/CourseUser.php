<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseUser extends Pivot
{
    protected $casts = [

        'end_date' => 'datetime:Y-m-d',
        'payment_1_date' => 'date',
        'payment_1_date' => 'date',
        'payment_1_date' => 'date',
        'progress' => 'array',
        'teaching' => 'boolean',
        'in_charge' => 'boolean'

    ];
}
