<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class RosterDive extends Model
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
    public function users()
    {
        return $this->belongsToMany(User::class, 'roster_user')->withPivot(['course_id', 'note', 'price', 'course_note', 'payed', 'gears'])->using(RosterUser::class);
    }

    public function roster()
    {
        return $this->belongsTo(Roster::class);
    }
}
