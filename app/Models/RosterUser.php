<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RosterUser extends Pivot
{
    protected $casts = [
        'payed' => 'boolean',
        'gears' => 'array',

    ];
}
