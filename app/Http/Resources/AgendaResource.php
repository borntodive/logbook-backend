<?php

namespace App\Http\Resources;

use App\Models\Course;
use App\Models\Size;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MinimalDivingResource extends JsonResource
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
            'logo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
            'name' => $this->name,
            'address' => $this->address,
        ];
    }
}
class AgendaResource extends ResourceCollection
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

        $data = [];
        foreach ($this->collection as $roster) {
            $date = date('d-m-Y', strtotime($roster->date));
            $time
                = date('H:i', strtotime($roster->date));
            $course_id = $roster->course_id;
            $course = null;
            if (!$course_id) {
                $course_id = $GUSTS_KEY;
                $course = $GUSTS_KEY;
            } else {
                $c = Course::findOrFail($course_id);
                $course
                    = $c->certification->name . ' ' . $c->number . '/' . $c->start_date->format('Y');;
            }
            $data[$date]['date'] = $date;
            $data[$date]['times'][$time]['diving'] = new MinimalDivingResource($roster->roster->diving);
            $data[$date]['times'][$time]['course'] = $course;
            $data[$date]['times'][$time]['time'] = $time;
            $data[$date]['times'][$time]['activity'] = $roster->roster->type;
        }
        $data = array_values($data);
        foreach ($data as $id => $date) {
            $data[$id]['times'] = array_values($date['times']);
        }
        return [
            'appointments' =>
            $data,

        ];
    }
}
