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
        $maxPoints = 0;
        $userStatus = [];
        foreach ($this->users as $user) {
            $points = 0;
            $allCompleted = true;
            if (!$user->pivot->teaching) {
                if (!is_array($user->pivot->progress))
                    continue;
                $this->caluculatePoint($user->pivot->progress, $points, $allCompleted);
                $userStatus[$user->pivot->user_id]['points'] = $points;
                if ($points > $maxPoints)
                    $maxPoints = $points;
                $userStatus[$user->pivot->user_id]['all_completed'] = $allCompleted;
            } else {
                $userStatus[$user->pivot->user_id]['points'] = $points;
                $userStatus[$user->pivot->user_id]['all_completed'] = $allCompleted;
            }
        }
        foreach ($this->users as $user) {
            $users[] = [
                'data' => new CourseUserResource($user),
                'teaching' => $user->pivot->teaching,
                'in_charge' => $user->pivot->in_charge,
                'progress' => $user->pivot->progress,
                'price' => $user->pivot->price,
                'payment_1' => $user->pivot->payment_1,
                'payment_2' => $user->pivot->payment_2,
                'payment_3' => $user->pivot->payment_3,
                'payment_1_date' => $user->pivot->payment_1_date,
                'payment_2_date' => $user->pivot->payment_2_date,
                'payment_3_date' => $user->pivot->payment_3_date,
                'timeline' => $userStatus[$user->pivot->user_id]['all_completed'] &&
                    $userStatus[$user->pivot->user_id]['points'] == $maxPoints ? 'ONTIME' : "DELAYED",
                'payment_complete' => $user->pivot->price - $user->pivot->payment_1 - $user->pivot->payment_2 - $user->pivot->payment_3 <= 0 ? true : false,
            ];
        }
        return [
            'id' => $this->id,
            'certification' => $this->certification,
            'specialities' => $this->specialities,
            'number' => $this->number . '/' . $this->start_date->format('Y'),
            'startDate' => $this->start_date ? $this->start_date->format('Y-m-d') : null,
            'endDate' => $this->end_date ? $this->end_date->format('Y-m-d') : null,
            'image' => Storage::url('images/courses/' . $this->certification->code . '.jpg'),
            'users' => $users,
        ];
    }

    private function caluculatePoint($array, &$points, &$allCompleted)
    {

        foreach ($array as $idx => $item) {

            if (isset($item['values'])) {
                if (!isset($item['values'][0]['values'])) {
                    $done = 0;
                    foreach ($item['values'] as $exercise) {
                        if ($exercise['date']) {
                            $points++;
                            $done++;
                        }
                    }
                    if ($done < count($item['values']) & $done > 0)
                        $allCompleted = false;
                }
                $this->caluculatePoint($item['values'], $points, $allCompleted);
            }
        }
    }
}
