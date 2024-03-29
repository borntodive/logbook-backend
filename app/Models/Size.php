<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Size extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });
    }
    public function equipments()
    {
        return $this->belongsToMany(Equipment::class);
    }
}
