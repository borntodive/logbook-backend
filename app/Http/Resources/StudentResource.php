<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $user = $this->users->where('id', $this->student_id)->first();
        $student = [
            'data' => new CourseUserResource($user),
            'price' => $user->pivot->price,
            'payment_1' => $user->pivot->payment_1,
            'payment_2' => $user->pivot->payment_2,
            'payment_3' => $user->pivot->payment_3,
            'payment_1_date' => $user->pivot->payment_1_date,
            'payment_2_date' => $user->pivot->payment_2_date,
            'payment_3_date' => $user->pivot->payment_3_date,
            'payment_complete' => $user->pivot->price - $user->pivot->payment_1 - $user->pivot->payment_2 - $user->pivot->payment_3 <= 0 ? true : false,
            'progress' => $user->pivot->progress,
        ];
        $end_date = $user->pivot->end_date ? Carbon::createFromDate($user->pivot->end_date) : null;
        return [
            'id' => $this->id,
            'certification' => $this->certification->name,
            'number' => $this->number . '/' . $this->start_date->format('Y'),
            'startDate' => $this->start_date ? $this->start_date->format('Y-m-d') : null,
            'endDate' => $end_date && $end_date->isValid() ? $end_date->format('Y-m-d') : null,
            'fullPrice' => $this->certification->price,
            'user' => $student,
        ];
    }
}
