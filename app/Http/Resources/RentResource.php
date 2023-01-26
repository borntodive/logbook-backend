<?php

namespace App\Http\Resources;

use App\Models\Course;
use FontLib\Table\Type\name;
use Illuminate\Http\Resources\Json\JsonResource;



class RentResource extends JsonResource
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
        foreach ($this->equipments as $eq) {
            $data['brand'] = $eq->brand;
            $data['code'] = $eq->code;
            $inv = $eq->getInventoryItem();
            $data['name'] = $inv->equipment->name;
            $data['size'] = $inv->size->name;
            $data['type'] = $inv->type->name;
            $data['price'] = $inv->equipment->price;
            $equipments[] = $data;
        }
        return [
            'id' => $this->id,
            'user' => new MinimalUserResource($this->user),
            'startDate' => $this->start_date->format('Y-m-d'),
            'endDate' => $this->end_date ? $this->end_date->format('Y-m-d') : null,
            'returnDate' => $this->return_date ? $this->return_date->format('Y-m-d') : null,
            'price' => $this->price,
            'payed' => $this->payed,
            'number' => $this->number,
            'usedDays' => $this->used_days,
            'name' => $this->number . '/' . $this->start_date->format('Y'),
            'payment_1' => $this->payment_1,
            'payment_2' => $this->payment_2,
            'equipments' => $equipments
        ];
    }
}
