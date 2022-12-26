<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CourseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $users = [];
        foreach ($this->users as $user) {
            $users[] = [
                'data' => new CourseUserResource($user),
                'teaching' => $user->pivot->teaching,
                'in_charge' => $user->pivot->in_charge,
                'progress' => $user->pivot->progress,
                'price' => $user->pivot->price,
                'payment_1' => $user->pivot->payment_1,
                'payment_2' => $user->pivot->price,
                'payment_3' => $user->pivot->price,
                'payment_complete' => $user->pivot->price - $user->pivot->payment_1 - $user->pivot->payment_2 - $user->pivot->payment_3 <= 0 ? true : false,
            ];
        }
        return [
            'id' => $this->id,
            'certification' => $this->certification,
            'number' => $this->number . '/' . $this->start_date->format('Y'),
            'startDate' => $this->start_date ? $this->start_date->format('Y-m-d') : null,
            'endDate' => $this->end_date ? $this->end_date->format('Y-m-d') : null,
            'image' => Storage::url('images/courses/' . $this->certification->code . '.jpg'),
            'users' => $users,
        ];
    }
}
