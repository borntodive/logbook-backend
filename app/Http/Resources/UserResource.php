<?php

namespace App\Http\Resources;

use App\Models\Size;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $sizes=[];
        $allSizes=Size::get();
        foreach ($this->equipments as $equipment){

            $s=$equipment->pivot->toArray();
            unset($s['user_id']);
            $s['name']=$equipment->name;
            $foundSize=$allSizes->firstWhere('id', $s['size_id']);
            $s['size']=$foundSize ? $foundSize->name : null;
            $sizes[]=$s;
        }
        return [
            'id' => $this->id,
            'firstname'=> $this->firstname,
            'lastname'=> $this->lastname,
            'gender'=> $this->gender,
            'phone'=> $this->phone,
            'cf'=> $this->cf,
            'height'=> $this->height,
            'weight'=> $this->weight,
            'birthdate'=> $this->birthdate ? $this->birthdate->format('Y-m-d') : null,
            'email'=> $this->email,
            'sizes'=>$sizes
        ];
    }
}
