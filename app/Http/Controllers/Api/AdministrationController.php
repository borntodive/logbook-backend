<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MinimalUserResource;
use App\Http\Resources\UserResource;
use App\Mail\ASDMembership;
use App\Mail\ForgotPssword;
use App\Mail\HappyBirthday;
use App\Mail\UserCreated;
use App\Models\Course;
use App\Models\Document;
use App\Models\Member;
use App\Models\Roster;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use File;

class AdministrationController extends Controller
{

    public function getBalance(Request $request)
    {
        if (!$request->user()->isAbleTo('manage-roles'))
            return response('unauthorized', 403);
        $users = User::has('unpayedCourses')->orHas('unpayedRents')->orHas('unpayedRosters')->get();
        $balance = [];
        $balance['total'] = 0;
        foreach ($users as $user) {
            $balance['users'][$user->id]['user'] = new MinimalUserResource($user);
            $balance['users'][$user->id]['total'] = 0;
            foreach ($user->unpayedCourses as $course) {
                $c = Course::find($course->pivot->course_id);
                $cBalance = $course->pivot->price - $course->pivot->payment_1 - $course->pivot->payment_2 - $course->pivot->payment_3;
                $balance['users'][$user->id]['activities']['courses'][] = [
                    'name'      => $c->certification->name . ' ' . $c->number . '/' . $c->start_date->format('Y'),
                    'startDate' => $c->start_date->format('d-m-Y '),
                    'ammount'   => $cBalance
                ];
                $balance['users'][$user->id]['total'] += $cBalance;
            }
            foreach ($user->unpayedRents as $rent) {
                $rBalance = $rent->price * $rent->used_days - $rent->payment_1 - $rent->payment_2;

                $balance['users'][$user->id]['activities']['rents'][] = [
                    'name' => $rent->number . '/' . $rent->start_date->format('Y'),
                    'startDate' => $rent->start_date->format('d-m-Y '),
                    'ammount' => $rBalance
                ];
                $balance['users'][$user->id]['total'] += $rBalance;
            }
            foreach ($user->unpayedRosters as $roster) {
                $r = Roster::findOrFail($roster->roster_id);
                $balance['users'][$user->id]['activities']['dives'][] = [
                    'date' => date('d-m-Y h:i', strtotime($roster->date)),
                    'diving' => $r->diving,
                    'type' => $r->type,
                    'name' => date('d-m-Y h:i', strtotime($roster->date)),

                    'ammount' => $roster->pivot->price
                ];
                $balance['users'][$user->id]['total'] += $roster->pivot->price;
            }
            $balance['total']
                += $balance['users'][$user->id]['total'];
        }
        $balance['users'] = array_values($balance['users']);
        return response()->json($balance);
    }
}
