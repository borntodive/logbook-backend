<?php

namespace App\Http\Resources;

use App\Models\Course;
use Illuminate\Http\Resources\Json\JsonResource;



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
        $dives = [];
        foreach ($this->roster_dives as $dive) {
            $dive->withCourseData = $this->withCourseData;
            $dives[] = new RosterDiveResource($dive);
        }


        return [
            'id' => $this->id,
            'date' => $this->date->format('Y-m-d\TH:i:s\Z'),
            'diving' => $this->diving,
            'type' => $this->type,
            'gratuities' => $this->gratuities,
            'dives' => $dives
        ];
    }
}
