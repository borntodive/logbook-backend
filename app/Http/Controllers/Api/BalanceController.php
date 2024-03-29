<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\BalanceResource;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Roster;
use App\Models\User;

class BalanceController extends Controller
{
    public function index(Request $request)
    {

        $user = User::with('unpayedRosters')->findOrFail($request->user()->id);
        $data['dives']['total'] = 0;
        $data['dives']['data'] = [];
        foreach ($user->unpayedRosters as $roster) {
            $r = Roster::findOrFail($roster->roster_id);
            if ($r->type !== 'DIVE')
                continue;
            $data['dives']['total'] += $roster->pivot->price;
            $data['dives']['data'][] = [
                'date' => date('d-m-Y h:i', strtotime($roster->date)),
                'diving' => $r->diving,
                'type' => $r->type,
                'ammount' => $roster->pivot->price
            ];
        }
        $data['courses']['total'] = 0;
        $data['courses']['data'] = [];
        foreach ($user->unpayedCourses as $course) {
            $cBalance = $course->pivot->price - $course->pivot->payment_1 - $course->pivot->payment_2 - $course->pivot->payment_3;
            $c = Course::find($course->pivot->course_id);
            $data['courses']['total'] += $cBalance;
            $data['courses']['data'][] = [
                'name' => $c->certification->name . ' ' . $c->number . '/' . $c->start_date->format('Y'),
                'startDate' => $c->start_date->format('d-m-Y '),
                'ammount' => $cBalance
            ];
        }
        $data['rents']['total'] = 0;
        $data['rents']['data'] = [];
        foreach ($user->unpayedRents as $rent) {
            $rBalance = $rent->price * $rent->used_days - $rent->payment_1 - $rent->payment_2;
            $data['rents']['total'] += $rBalance;
            $data['rents']['data'][] = [
                'name' => $rent->number . '/' . $rent->start_date->format('Y'),
                'startDate' => $rent->start_date->format('d-m-Y '),
                'ammount' => $rBalance
            ];
        }
        $data['membership']['total'] = $user->asd_membership ? 0 : 25;
        return response()->json(['data' => ['balance' => $data]]);
    }
}
