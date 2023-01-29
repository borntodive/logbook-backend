<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiveSite extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',

    ];

    public function divings()
    {
        return $this->belongsToMany(Diving::class);
    }

    public function dives()
    {
        return $this->hasMany(RosterDive::class);
    }
}
