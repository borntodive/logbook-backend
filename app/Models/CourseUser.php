<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class CourseUser extends Pivot
{
    protected $casts = [

        'end_date' => 'datetime:Y-m-d',
        'progress' => 'array',
        'teaching' => 'boolean',
        'in_charge' => 'boolean'

    ];
}
