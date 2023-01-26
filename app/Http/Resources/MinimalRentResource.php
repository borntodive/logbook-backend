<?php

namespace App\Http\Resources;

use App\Models\Course;
use FontLib\Table\Type\name;
use Illuminate\Http\Resources\Json\JsonResource;



class MinimalRentResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'user' => new MinimalUserResource($this->user),
            'startDate' => $this->start_date->format('Y-m-d'),
            'endDate' => $this->end_date ? $this->end_date->format('Y-m-d') : null,
            'returnDate' => $this->return_date ? $this->return_date->format('Y-m-d') : null,
            'usedDays' => $this->used_days,
            'price' => $this->price,
            'payed' => $this->payed,
            'number' => $this->number,
            'name' => $this->number . '/' . $this->start_date->format('Y'),

        ];
    }
}
