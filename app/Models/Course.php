<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Course extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
    ];
    protected $casts = [
        'start_date' => 'datetime:Y-m-d',
        'end_date' => 'datetime:Y-m-d',
        'specialities' => 'array',

    ];
    public function certification()
    {
        return $this->belongsTo(Certification::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['end_date', 'progress', 'price', 'teaching', 'in_charge', 'payment_1', 'payment_2', 'payment_3'])->using(CourseUser::class);
    }

    public function getEmptyProgress()
    {
        $activities = $this->certification->activities;
        if ($this->certification->own_speciality) {
            $newActivities =                [
                'label' => 'OW',
                'order' => 3,
                'values' => null
            ];
            $newActivitiesCW =                [
                'label' => 'CW',
                'order' => 2,
                'values' => null
            ];
            foreach ($this->specialities as $idx => $spId) {
                $cert = Certification::find($spId);
                if ($cert) {

                    $specialityActivities = [
                        'order'  => $idx + 1,
                        'label' => $cert->name,
                        'values' => $this->findFirstOW($cert->activities, 'OW', $cert)
                    ];
                    $newActivities['values'][] = $specialityActivities;
                    //$cw = null;
                    $cw = $this->findFirstOW($cert->activities, 'CW');
                    if ($cw) {
                        $specialityActivities = [
                            'order'  => $idx + 1,
                            'label' => $cert->name,
                            'values' => $cw
                        ];
                        $newActivitiesCW['values'][] = $specialityActivities;
                    }
                }
            }
            $activities[] = $newActivities;
            if ($newActivitiesCW['values'] && count($newActivitiesCW['values']))
                $activities[] = $newActivitiesCW;
        }
        if ($activities) {
            $this->recuriveForEach($activities);
        }
        return $activities;
    }

    private function findFirstOW($array, $section, $cert = null)
    {
        $out = null;

        foreach ($array as $key => $value) {
            if ($out)
                break;
            if ($value['label'] == $section) {
                foreach ($value['values'] as $v) {
                    if ($v['order'] == 1) {
                        $out = $v['values'];
                        break;
                    }
                }
            }
        }
        return $out;
    }
    private function recuriveForEach(&$array)
    {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                if (isset($value['values'])) {
                    $this->recuriveForEach(($value['values']));
                } else {
                    $value['date'] = null;
                    $value['instructor']['name'] = null;
                    $value['instructor']['number'] = null;
                    $value['instructor']['id'] = null;
                }
            }
        }
    }
}
