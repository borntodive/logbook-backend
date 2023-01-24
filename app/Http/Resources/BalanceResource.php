<?php

namespace App\Http\Resources;

use App\Models\Course;
use App\Models\Size;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BalanceResource extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data['dives']['total'] = 0;
        $data['dives']['data'] = [];
        dd($this);
        foreach ($this->unpayedRosters as $roster) {
            $data['dives']['total'] += $roster->pivot->price;
            $data['dives']['data'][] = [
                'date' => date('d-m-Y', strtotime($roster->date)),
                'ammount' => $roster->pivot->price
            ];
        }
        $data['courses']['total'] = 0;
        $data['courses']['data'] = [];
        foreach ($this->unpayedCourses as $course) {
            $cBalance = $course->pivot->price - $course->pivot->payment_1 - $course->pivot->payment_2 - $course->pivot->payment_3;
            $c = Course::find($course->pivot->course_id);
            $data['courses']['total'] += $cBalance;
            $data['courses']['data'][] = [
                'name' => $c->certification->name . ' ' . $c->number . '/' . $c->start_date->format('Y'),
                'ammount' => $cBalance
            ];
        }
        return [
            'balance' =>
            $data,

        ];
    }
}
