<?php

namespace App\Observers;

use App\Models\Certification;
use Illuminate\Support\Str;

class CertificationObserver
{
    /**
     * Handle the Course "created" event.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function created(Certification $certification)
    {
        $activities = $certification->activities;
        if (is_array($activities)) {
            $this->recuriveForEach($activities);
            $certification->activities = $activities;
            $certification->save();
        }
    }
    private function recuriveForEach(&$array)
    {

        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                $value['uuid'] = Str::uuid();
                if (isset($value['values'])) {
                    $this->recuriveForEach(($value['values']));
                }
            }
        }
    }
    /**
     * Handle the Course "updated" event.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function updated(Certification $certification)
    {
        //
    }

    /**
     * Handle the Course "deleted" event.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function deleted(Certification $certification)
    {
        //
    }

    /**
     * Handle the Course "restored" event.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function restored(Certification $certification)
    {
        //
    }

    /**
     * Handle the Course "force deleted" event.
     *
     * @param  \App\Models\Course  $course
     * @return void
     */
    public function forceDeleted(Certification $certification)
    {
        //
    }
}
