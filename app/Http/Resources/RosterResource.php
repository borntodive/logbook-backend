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
        $course = $this->course;
        $GUSTS_KEY = 'GUESTS';
        $in_charge = false;
        $teaching = false;

        if ($course !== $GUSTS_KEY) {
            $courseUser = $course->users->where('id', $this->id)->first();

            $in_charge = $courseUser->pivot->in_charge;
            $teaching = $courseUser->pivot->teaching;
        }
        return [
            'id' => $this->id,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'note' => $this->pivot->note,
            'price' => $this->pivot->price,
            'in_charge' => $in_charge,
            'teaching' => $teaching,
            'payed' => $this->pivot->payed,
            'gears' => $this->pivot->gears
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

        $divers = null;
        foreach ($this->users as $user) {
            $course_id = $user->pivot->course_id;
            if (!$course_id) {
                $course_id = $GUSTS_KEY;
                $user->course = $GUSTS_KEY;
            } else {
                $course = Course::find($user->pivot->course_id);
                $user->course = $course;
            }

            if (!isset($divers[$course_id])) {
                $course_name = $course_id;
                if ($user->pivot->course_id) {
                    $course_name = $course->certification->name . ' ' . $course->number . '/' . $course->start_date->format('Y');
                }
                $divers[$course_id]['course'] = $course_name;
                $divers[$course_id]['course_id'] = $course_id;
            }
            $divers[$course_id]['divers'][] = new RosterUserResource($user);
        }
        if (!isset($divers[$GUSTS_KEY])) {
            $divers[$GUSTS_KEY]['course']  =
                $GUSTS_KEY;
            $divers[$GUSTS_KEY]['divers']  = [];
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
            'type' => $this->type,
            'divers' => array_values($divers)
        ];
    }
}
