<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',

    ];
    protected $casts = [
        'items' => 'array',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
    public function size()
    {
        return $this->belongsTo(Size::class);
    }
    public function type()
    {
        return $this->belongsTo(EquipmentType::class, 'equipment_type_id');
    }
}
