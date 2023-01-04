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
        'end_date' => 'datetime:Y-m-d'
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
        $progress = null;
        if ($activities) {
            $this->recuriveForEach($activities);
        }
        return $activities;
    }

    private function recuriveForEach(&$array)
    {
        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $value['uuid'] = Str::uuid();
                if (isset($value['values'])) {
                    $this->recuriveForEach(($value['values']));
                } else {
                    $value['uuid']
                        = Str::uuid();
                    $value['date'] = null;
                    $value['instructor']['name'] = null;
                    $value['instructor']['number'] = null;
                    $value['instructor']['id'] = null;
                }
            }
        }
    }
}
