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
        $highlights = [];
        if ($this->unpayedItems())
            $highlights[] = 'balance';
        if ($this->openRents)
            $highlights[] = 'rents';
        if ($this->openedCourses)
            $highlights[] = 'courses';
        if ($this->rosters()->whereDate('date', ">=", date('Y-m-d')))
            $highlights[] = 'agenda';
        return [
            'data' => [

                'id' => $this->id,
                'avatar' =>
                $this->getAvatarUrl(),
                'firstname' => $this->firstname,
                'lastname' => $this->lastname,
                'email' => $this->email,
                'roles' => $this->roles->pluck('name'),
                'permissions' => $this->allPermissions()->pluck('name'),
                'highlights' => $highlights
            ],
            'token' => $this->isLogin ? $this->createToken('ElenaLaviniaBeatriceSara')->plainTextToken : null
        ];
    }
}
