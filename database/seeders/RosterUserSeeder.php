<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Roster;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Exception;

class RosterUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rosters = Roster::get();
        $addedUsers = null;
        foreach ($rosters as $roster) {
            $courses = Course::inRandomOrder()->limit(3)->get();
            foreach ($courses as $course) {
                foreach ($course->users as $user) {
                    try {
                        $addedUsers[] = $user->id;
                        $roster->users()->attach($user->id, ['course_id' => $course->id]);
                    } catch (Exception $e) {
                    }
                }
            }
            $users = User::inRandomOrder()->whereNotIn('id', $addedUsers)->limit(8)->get();
            foreach ($users as $user) {
                try {
                    $roster->users()->attach($user->id, ['course_id' => null]);
                } catch (Exception $e) {
                }
            }
        }
    }
}
