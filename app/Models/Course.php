<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
     protected $guarded = [
        'id',
    ];
 protected $casts = [
        'start_date' => 'datetime:Y-m-d',
        'end_date' => 'datetime:Y-m-d',
    ];
    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['end_date','progress','price','teaching','in_charge']);
    }
}
