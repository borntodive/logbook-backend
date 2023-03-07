<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentEquipment extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',

    ];

    public function getInventoryItem()
    {
        return Inventory::whereJsonContains('items', [['code' => $this->code]])->first();
    }

    public function rent()
    {
        return $this->belongsTo(Rent::class);
    }
}
