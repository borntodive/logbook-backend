<?php

namespace App\Http\Resources;

use App\Models\Size;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

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
            'gender' => $this->gender,
            'birthdate' => Carbon::create($this->birthdate)->format('d-m-Y'),
            'avatar' =>
            $this->getAvatarUrl(),

            'name' => $this->lastname . ' ' . $this->firstname,
            'instructor' => $this->user_duty_id === 3 ? true : false
        ];
    }
}
