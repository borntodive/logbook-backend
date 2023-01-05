<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RosterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $types = [
            1 => "POOL",
            2 => "DIVE"
        ];
        return [
            'id' => $this->id,
            'date' => $this->date,
            'note' => $this->note,
            'cost' => $this->cost,
            'price' => $this->price,
            'diving' => $this->diving,
            'type' => $types[$this->type]
        ];
    }
}
