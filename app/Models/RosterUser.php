<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RosterUser extends Pivot
{

    protected $casts = [
        'payed' => 'boolean',
        'gears' => 'array',

    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function dives()
    {
        return $this->hasMany(RosterDive::class);
    }
    public function rosters()
    {
        return $this->belongsToMany(Roster::class, 'roster_dives', 'roster_dive.id', 'roster_id');
    }
}
