<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->belongsToMany(User::class)->withPivot(['end_date', 'progress', 'price', 'teaching', 'in_charge'])->using(CourseUser::class);
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
                if (isset($value['values'])) {
                    $this->recuriveForEach(($value['values']));
                } else {
                    $value['date'] = null;
                    $value['instructor']['name'] = null;
                    $value['instructor']['number'] = null;
                }
            }
        }
    }
}
