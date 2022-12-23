<?php

namespace App\Http\Resources;

use App\Models\Size;
use Illuminate\Http\Resources\Json\JsonResource;

class MinimalUserResource extends JsonResource
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
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'name' => $this->lastname . ' ' . $this->firstname,
            'instructor' => $this->user_duty_id === 3 ? true : false
        ];
    }
}
