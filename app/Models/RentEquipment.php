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
        $code = $this->code;
        $eq = Inventory::whereJsonContains('items', [['code' => $code]])->first();

        return Inventory::whereJsonContains('items', [['code' => $this->code]])->first();
    }
    public function getAvailability()
    {
        $inventory = Inventory::whereJsonContains('items', [['code' => $this->code]])->first();

        foreach ($inventory->items as $item) {
            if ($item['code'] == $this->code) {
                return $item['available'] ? true : false;
            }
        }
        return false;
    }
}
