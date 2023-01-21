<?php

namespace App\Http\Resources;

use App\Models\Inventory;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
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
        foreach ($types as $type) {
            $sizes = $this->inventory_sizes()->where('equipment_type_id', $type->id)->distinct()->get();
            foreach ($sizes as $size) {
                $eqs
                    = Inventory::where('equipment_type_id', $type->id)->where('equipment_id', $this->id)->where('size_id', $size->id)->first();
                $codes = [];
                foreach ($eqs->codes as $code) {
                    $codes[] = $code;
                    $total++;
                }
                $equipments[$type->name][$size->name] = $codes;
            }
        }
        return [
            'id' => $this->id,
            'name' => $this->name,
            'has_sizes' => $this->has_sizes,
            'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            'count' => $total,
        ];
    }
}
