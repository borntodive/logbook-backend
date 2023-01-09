<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class EquipmentUser extends Pivot
{
    protected $casts = [

        'owned' => 'boolean'

    ];
}
