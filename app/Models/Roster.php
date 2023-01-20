<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Roster extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];
    protected $casts = [
        'date' => 'datetime',
    ];
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('date', 'asc');
        });
    }
    public function scopePools($query)
    {
        return $query->where('type', 1);
    }

    public function scopeDives($query)
    {
        return $query->where('type', 2);
    }

    public function roster_dives()
    {
        return $this->hasMany(RosterDive::class)->orderBy('date', 'asc');;
    }
    public function diving()
    {
        return $this->belongsTo(Diving::class);
    }
}
