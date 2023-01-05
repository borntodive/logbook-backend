<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diving extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',

    ];
    public function rosters()
    {
        return $this->hasMany(Roster::class);
    }
}
