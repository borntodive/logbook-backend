<?php

namespace App\Helpers;

use App\Models\Course;
use App\Models\Inventory;
use App\Models\Rent;
use App\Models\RentEquipment;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;


class StudentRecordHelper
{
    private $course;
    private $student;
    private $progress;



    public function __construct(Course $course, $student_id)
    {
        $this->course = $course;
        $this->student = $course->users()->where('user_id', $student_id)->first();
        $this->progress = $this->student->pivot->progress;
    }

    public function print()
    {
        $theory = Arr::first($this->getActivity('THEORY'));
        $rc = $this->getTheory($theory, 'Ripassi delle conoscenze');
        $exam
            = $this->getTheory($theory, 'Esame');
    }
    private function getActivity($activity)
    {
        return
            Arr::where($this->progress, function (string|int|array $value, int $key) use ($activity) {
                return $value['label'] == $activity;
            });
    }

    private function getTheory($activity, $part)
    {
        $rc =
            Arr::first(Arr::where($activity['values'], function (string|int|array $value, int $key) use ($activity, $part) {
                return $value['label'] == $part;
            }));
        if (!$rc)
            return null;
        $app = $this->searchExerciseByName($rc, $part);
        return ['date' => $app['date'], 'instructor' => $app['instructor']];
    }

    private function searchExerciseByName($array, $exerciseName)
    {
        if (isset($array['values'])) {
            return $this->searchExerciseByName(Arr::first($array['values']), $exerciseName);
        }

        //dd($array);
        if ($array['label'] == $exerciseName) {
            return $array;
        }
        return null;
    }
}
