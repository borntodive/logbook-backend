<?php

namespace App\Http\Resources;

use App\Models\Size;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
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
            'data' => [
                'id' => $this->id,
                'avatar' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'email' => $this->email,
                'roles' => $this->roles->pluck('name'),
                'permissions' => $this->allPermissions()->pluck('name')
            ],
            'token' =>  $this->createToken('ElenaLaviniaBeatriceSara')->plainTextToken
        ];
    }
}
