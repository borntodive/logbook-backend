<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    protected $casts = [
        'date' => 'datetime',
    ];

    public function scopePools($query)
    {
        return $query->where('type', 1);
    }

    public function scopeDives($query)
    {
        return $query->where('type', 2);
    }
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['course_id', 'note', 'price', 'course_note', 'payed', 'gears'])->using(RosterUser::class);
    }
    public function diving()
    {
        return $this->belongsTo(Diving::class);
    }
}
