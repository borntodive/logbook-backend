<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $courses = Course::get();
        foreach ($courses as $course) {
            $users = User::with('duty')->inRandomOrder()->limit(10)->get();
            $incharge = false;
            $teaching = false;
            $found = false;
            $teachingCount = 0;
            foreach ($users as $user) {
                $price = $course->certification->discounted_price;
                $progress = null;
                if (($user->duty->name == 'Instructor' || $user->duty->name == 'Divemaster') && $teachingCount < 3) {
                    $teaching = true;
                    $teachingCount++;
                    $price = null;
                }
                if ($user->duty->name == 'Instructor' && !$found) {
                    $found = true;
                    $incharge = true;
                }
                if (!$teaching) {
                    $progress = $course->getEmptyProgress();
                }
                $course->users()->attach($user->id, ['price' => $price, 'teaching' => $teaching, 'in_charge' => $incharge, 'progress' => $progress]);
                $incharge = false;
                $teaching = false;
            }
        }
    }
}
