<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Equipment extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',

    ];
    protected $casts = [

        'has_sizes' => 'boolean'

    ];
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('order', 'asc');
        });
    }
    public function sizes()
    {
        return $this->belongsToMany(Size::class)->orderBy('order');
    }

    public function types()
    {
        return $this->hasManyThrough(
            EquipmentType::class,
            Inventory::class,
            'equipment_id', // Foreign key on the environments table...
            'id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'equipment_type_id' // Local key on the environments table...
        );
    }
    public function inventory_sizes()
    {
        return $this->hasManyThrough(
            Size::class,
            Inventory::class,
            'equipment_id', // Foreign key on the environments table...
            'id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'size_id' // Local key on the environments table...
        );
    }
}
