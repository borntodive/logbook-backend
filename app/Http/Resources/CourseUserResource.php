<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CourseUserResource extends JsonResource
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
            'firstname'=> $this->firstname,
            'lastname'=> $this->lastname,
            'gender'=> $this->gender,
            'phone'=> $this->phone,
            'birthdate'=> $this->birthdate ? $this->birthdate->format('Y-m-d') : null,
            'email'=> $this->email,
        ];
    }
}
