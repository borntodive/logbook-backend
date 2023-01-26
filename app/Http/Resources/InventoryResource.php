<?php

namespace App\Http\Resources;

use App\Helpers\InventoryHelper;
use App\Models\Inventory;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class InventoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $equipments = [];
        $types = $this->types()->distinct()->get();
        $total = 0;
        $totalAvailable = 0;
        foreach ($types as $type) {
            $sizes = $this->inventory_sizes()->where('equipment_type_id', $type->id)->distinct()->get();
            foreach ($sizes as $size) {
                $eqs
                    = Inventory::where('equipment_type_id', $type->id)->where('equipment_id', $this->id)->where('size_id', $size->id)->first();
                $invHelper = new InventoryHelper($eqs);
                $items = $invHelper->checkEquipmentsAvailability();
                foreach ($items as $item) {
                    $total++;
                    if ($item['available'])
                        $totalAvailable++;
                }
                $equipments[$type->name][$size->name] = $items;
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => Storage::url('images/equipments/' . $this->equipments . '.jpeg'),
            'has_sizes' => $this->has_sizes,
            'count' => $total,
            'countAvailable' => $totalAvailable,
            'inventory' => $equipments,

        ];
    }
}
