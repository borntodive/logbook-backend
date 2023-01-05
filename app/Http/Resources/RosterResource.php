<?php

namespace App\Http\Resources;

use App\Models\Course;
use Illuminate\Http\Resources\Json\JsonResource;

class RosterUserResource extends JsonResource
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
            'note' => $this->pivot->note,
            'price' => $this->pivot->price,
            'payed' => $this->pivot->payed,
        ];
    }
}

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
        $GUSTS_KEY = 'GUESTS';
        $types = [
            1 => "POOL",
            2 => "DIVE"
        ];
        $divers = null;
        foreach ($this->users as $user) {
            $course_id = $user->pivot->course_id;
            if (!$course_id)
                $course_id = $GUSTS_KEY;
            if (!isset($divers[$course_id])) {
                $course_name = $course_id;
                if ($user->pivot->course_id) {
                    $course = Course::find($user->pivot->course_id);
                    $course_name = $course->certification->name . ' ' . $course->number . '/' . $course->start_date->format('Y');
                }
                $divers[$course_id]['course'] = $course_name;
            }
            $divers[$course_id]['divers'][] = new RosterUserResource($user);
        }
        $guests = $divers[$GUSTS_KEY];
        unset($divers[$GUSTS_KEY]);
        $c  = array_column($divers, 'course');
        array_multisort($c, SORT_ASC, $divers);
        $divers[$GUSTS_KEY] = $guests;

        return [
            'id' => $this->id,
            'date' => $this->date,
            'note' => $this->note,
            'cost' => $this->cost,
            'price' => $this->price,
            'diving' => $this->diving,
            'type' => $types[$this->type],
            'divers' => array_values($divers)
        ];
    }
}
