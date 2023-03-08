<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RosterDivePostRequest;
use App\Http\Requests\RosterDiverPostRequest;
use App\Http\Requests\RosterPostRequest;
use App\Http\Resources\RosterResource;
use App\Models\Course;
use App\Models\Equipment;
use App\Models\Roster;
use App\Models\RosterDive;
use App\Models\RosterUser;
use App\Models\Size;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Carbon;
use Spatie\Browsershot\Browsershot;
use PDF;
use mikehaertl\wkhtmlto\Pdf as PdfT;
use SebastianBergmann\Type\FalseType;

class RosterController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->isAbleTo('view-all'))
            return response('unauthorized', 403);
        $sort = $request->get('sort', 'date');
        $type = $request->get('type', 'POOL');
        $filter = $request->get('filter', 'future');
        $sortDirection = $request->get('sortDirection', 'ASC');
        $rosters = Roster::where('type', $type)->orderBy($sort, $sortDirection);
        if ($filter == 'future')
            $rosters = $rosters->whereDate('date', '>=', date('Y-m-d'));
        elseif ($filter == 'past')
            $rosters = $rosters->whereDate('date', '<', date('Y-m-d'));
        return RosterResource::collection($rosters->jsonPaginate());
    }
    public function store(RosterPostRequest $request)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();
            $data = $request->safe()->except(['price', 'cost']);
            $roster = Roster::create($data);
            $data = $request->safe()->only(['price', 'cost']);
            $data['date'] = $roster->date;
            $roster->roster_dives()->create($data);
            return new RosterResource($roster);
        } else return response('unauthorized', 403);
    }
    public function destroy(Request $request, Roster $roster)
    {
        if ($request->user()->isAbleTo('delete-all')) {
            $dives = $roster->roster_dives;
            foreach ($dives as $dive) {
                $dive->users()->detach();
            }
            $roster->roster_dives()->delete();
            $roster->delete();
            return response()->json(['status' => 'deleted']);
        } else return response('unauthorized', 403);
    }

    public function get(Request $request, Roster $roster)
    {
        if ($request->user()->isAbleTo('view-all')) {
            return new RosterResource($roster);
        } else return response('unauthorized', 403);
    }

    public function update(RosterPostRequest $request, Roster $roster)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();
            $data = $request->safe()->except(['price', 'cost']);
            $roster->fill($data);
            $roster->save();
            foreach ($roster->roster_dives as $dive) {
                $dive->date = Carbon::createFromFormat('Y-m-d h:i', $roster->date->format('Y-m-d') . " " . $dive->date->format('h:i'))->toIso8601String();
                $dive->save();
            }
            return new RosterResource($roster);
        } else return response('unauthorized', 403);
    }
    public function updateDive(RosterDivePostRequest $request, RosterDive $roster)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();
            $roster->fill($request->safe()->toArray());
            $roster->save();
            return response()->json(['message' => 'success']);
        } else return response('unauthorized', 403);
    }
    public function duplicateDive(Request $request, RosterDive $roster)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $newDive = $roster->replicate();
            $newDive->created_at = Carbon::now();
            $newDive->updated_at = Carbon::now();
            $newDive->date = Carbon::createFromFormat('Y-m-d h:i', $roster->date->format('Y-m-d') . " " . $roster->date->clone()->addHours(1)->format('h:i'))->toIso8601String();

            $newDive->save();
            $data = [];
            foreach ($roster->users as $diver) {

                $d = $diver->pivot->toArray();
                $id = $d['user_id'];
                unset($d['roster_dive_id']);
                unset($d['user_id']);
                $data[$id] = $d;
            }
            $newDive->users()->attach($data);
            return response()->json(['message' => 'success']);
        } else return response('unauthorized', 403);
    }
    public function addDive(RosterDivePostRequest $request, Roster $roster)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();
            $roster->roster_dives()->create($request->safe()->toArray());
            return response()->json(['message' => 'success']);
        } else return response('unauthorized', 403);
    }
    public function updateDiver(RosterDiverPostRequest $request, RosterDive $roster, $diver_id)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();
            $data = collect($request->safe())->toArray();
            $isDefault = $data['default'];
            unset($data['default']);

            $roster->users()->sync([
                $diver_id => $data,
            ], false);
            $u = $roster->users()->where('user_id', $diver_id)->first();
            if ($isDefault) {
                //$u->equipments()->detach();

                foreach ($data['gears'] as $id => $equipment) {
                    $e = $u->equipments()->where('equipment_id', $equipment['equipment_id'])->first();
                    if (!$e->pivot->owned) {
                        $u->equipments()->detach($equipment['equipment_id']);
                        $u->equipments()->attach($equipment['equipment_id'], ['number' => $equipment['number'], 'size_id' => $equipment['size_id']]);
                    }
                }
            }

            $course = 'GUESTS';
            if ($u->course_id) {
                $course = Course::find($u->course_id);
            }
            $u->course = $course;
            return response()->json(['message' => 'success']);
        } else return response('unauthorized', 403);
    }
    public function updateDiverPayment(Request $request, RosterDive $roster, $diver_id)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $roster->users()->sync([
                $diver_id => ['payed' => true],
            ], false);

            return response()->json(['message' => 'success']);
        } else return response('unauthorized', 403);
    }
    public function updateDiverUnPayment(Request $request, RosterDive $roster, $diver_id)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $roster->users()->sync([
                $diver_id => ['payed' => false],
            ], false);

            return response()->json(['message' => 'success']);
        } else return response('unauthorized', 403);
    }
    public function addUser(Request $request, RosterDive $roster, User $user)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $course_id = $request->input('course_id');
            if (!$course_id || $course_id == 'GUESTS')
                $course_id = null;

            $roster->users()->attach($user->id, ['course_id' => $course_id, 'gears' => $user->getDefaultSizes(), 'price' => $user->duty->name == 'Diver' ? $roster->price : $roster->cost]);
            return response()->json(['message' => 'success']);
        } else return response('unauthorized', 403);
    }
    public function addCourse(Request $request, RosterDive $roster, Course $course)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            foreach ($course->users as $user) {
                try {
                    $userPrice = $user->duty->name == 'Diver' ? $roster->price + 5 : $roster->cost;
                    if ($roster->roster->type !== "DIVE")
                        $userPrice = null;
                    $roster->users()->attach($user->id, ['course_id' => $course->id, 'gears' => $user->getDefaultSizes(), 'price' => $userPrice]);
                } catch (Exception $e) {
                }
            }
            return response()->json(['message' => 'success']);
        } else return response('unauthorized', 403);
    }
    public function destroyCourse(Request $request, RosterDive $roster, $course_id)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            if ($course_id !== 'GUESTS')
                $users = $roster->users()->where('course_id', $course_id)->get();
            else
                $users = $roster->users()->where('course_id', null)->get();
            $roster->users()->detach($users->pluck('id'));
            return response()->json(['message' => 'success']);
        } else return response('unauthorized', 403);
    }

    public function destroyDive(Request $request, RosterDive $roster)
    {
        if ($request->user()->isAbleTo('edit-all')) {

            $roster->users()->detach();
            $roster->delete();
            return response()->json(['message' => 'success']);
        } else return response('unauthorized', 403);
    }
    public function destroyUser(Request $request, RosterDive $roster, $user_id)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $roster->users()->detach($user_id);
            return response()->json(['message' => 'success']);
        } else return response('unauthorized', 403);
    }

    public function print(Request $request, Roster $roster)
    {
        //$rRes = new RosterResource($roster);
        $rosterRes = json_decode(json_encode(new RosterResource($roster)));
        $equipments = Equipment::get();
        $equipmentTraslations = json_decode(
            '{
                "equipments": {
                    "suit": "Muta",
                    "bcd": "GAV",
                    "boot": "Calzari",
                    "fins": "Pinne",
                    "mask": "Maschera",
                    "weightsBelt": "Cintura pesi",
                    "regulator": "Erogatore",
                    "weight": "Pesi",
                    "tank": "Bombola"
                },
                "sizes": {
                    "xxxs": "XXXS",
                    "xxs": "XXS",
                    "xs": "XS",
                    "s": "S",
                    "m": "M",
                    "lg": "L",
                    "xl": "XL",
                    "xxl": "XXL",
                    "uni": "UNI",
                    "4L": "4L",
                    "5L": "5L",
                    "7L": "7L",
                    "10L": "10L",
                    "11L": "11L",
                    "12L": "12L",
                    "15L": "15L",
                    "18L": "18L",
                    "B10L": "10+10L",
                    "B12L": "12+12L",
                    "HOGA": "HOGA",
                    "OCTO": "OCTO",
                    "3P": "3P",
                    "4P": "4P",
                    "5P": "5P",
                    "6P": "6P",
                    "xxxsm": "XXXS-M",
                    "xxsm": "XXS-M",
                    "xsm": "XS-M",
                    "sm": "S-M",
                    "mm": "M-M",
                    "lgm": "L-M",
                    "xlm": "XL-M",
                    "xxlm": "XXL-M",
                    "xxxsf": "XXXS-F",
                    "xxsf": "XXS-F",
                    "xsf": "XS-F",
                    "sf": "S-F",
                    "mf": "M-F",
                    "lgf": "L-F",
                    "xlf": "XL-F",
                    "xxlf": "XXL-F",
                    "O.5": "0.5",
                    "1": "1",
                    "1.5": "1.5",
                    "2": "2",
                    "2.5": "2.5",
                    "3": "3",
                    "3.5": "3.5",
                    "4": "4"
                }
            }'
        );
        $equipments = $equipments->toArray();
        $sizes = collect($equipmentTraslations->sizes);
        foreach ($equipments as $idx => $equipment) {
            $name = $equipment['name'];
            $equipments[$idx]['translation'] = $equipmentTraslations->equipments->$name;
        }
        foreach ($rosterRes->dives as $id => $dive) {
            foreach ($dive->divers as $idx => $course) {
                if (count($course->divers) <= 0)
                    unset($rosterRes->dives[$id]->divers[$idx]);
            }
        }
        $pdf = PDF::loadView('print_roster', ['roster' => $rosterRes, 'equipments' => $equipments, 'sizes' => $sizes])->setPaper('a4', 'landscape');
        $rosterType = '';
        if ($roster->type == 'POOL') {
            $rosterType = 'Piscina';
        } elseif ($roster->type == 'DIVE') {
            $rosterType = 'Immersione';
        } elseif ($roster->type == 'THEORY') {
            $rosterType = 'Teoria';
        }
        $filename = "Roster " . $rosterType . " del " . date('dmY-Hi', strtotime($roster->date)) . ".pdf";
        return $pdf->stream($filename);
    }
    public function printAdmin(Request $request, Roster $roster)
    {
        //$rRes = new RosterResource($roster);
        $roster->withCourseData = true;
        $divers = [];
        $totals['dive']['income'] = 0;
        $totals['course']['income']  = 0;
        $totals['equipment']['income']  = 0;
        $totals['dive']['cost'] = 0;
        $totals['course']['cost']  = 0;
        $totals['equipment']['cost']  = 0;
        $countedCourses = [];
        $countedRents = [];
        $rosterRes = json_decode(json_encode(new RosterResource($roster)));
        $addedCourses = [];
        foreach ($rosterRes->dives as $dive_id => $dive) {
            $totalDivers = 0;
            foreach ($dive->divers as $course_id => $course) {
                foreach ($course->divers as $diver_id => $diver) {
                    $totalDivers++;
                    if (!isset($divers[$diver->id])) {
                        $divers[$diver->id]['name'] = $diver->lastname . ' ' . $diver->firstname;
                        $divers[$diver->id]['balance']['dive'] = 0;
                        $divers[$diver->id]['balance']['course'] = 0;
                        $divers[$diver->id]['balance']['equipment'] = 0;
                        $divers[$diver->id]['balance']['total'] = 0;
                    }
                    if (!$diver->payed)
                        $divers[$diver->id]['balance']['dive'] += $diver->price;
                    else
                        $divers[$diver->id]['balance']['dive'] = 0;
                    $user = User::find($diver->id);
                    foreach ($user->courses as $course) {
                        $student = $course->users()->where('user_id', $user->id)->first();
                        if (isset($student->pivot)  && !$student->pivot->teaching && !isset($countedCourses[$diver->id][$student->pivot->course_id])) {
                            $balance = $student->pivot->price - $student->pivot->payment_1 - $student->pivot->payment_2 - $student->pivot->payment_3;
                            $divers[$diver->id]['balance']['course'] += $balance;
                            $totals['course']['income']  += $balance;
                            $divers[$diver->id]['balance']['total'] += $balance;
                            $countedCourses[$diver->id][$student->pivot->course_id] = true;
                        }
                    }
                    $unpayedRents = $user->unpayedRents;
                    foreach ($unpayedRents as $rent) {
                        if (!isset($countedRents[$diver->id][$rent->id])) {
                            $rBalance = $rent->price * $rent->used_days - $rent->payment_1 - $rent->payment_2;
                            $divers[$diver->id]['balance']['equipment'] += $rBalance;
                            $totals['equipment']['income']  += $rBalance;
                            $countedRents[$diver->id][$rent->id] = true;
                        }
                    }


                    $divers[$diver->id]['balance']['total'] = $divers[$diver->id]['balance']['dive'] + $divers[$diver->id]['balance']['equipment'];

                    $totals['dive']['income'] += $diver->price;
                }
            }
            $totals['dive']['cost'] += $dive->cost * $totalDivers - $dive->cost * $dive->gratuities;
        }
        $view = view('print_roster_admin', ['roster' => $rosterRes, 'divers' => $divers, 'totals' => $totals])->render();
        $divers = array_values($divers);
        usort($divers, function ($item1, $item2) {
            return $item1['name'] <=> $item2['name'];
        });

        //return $view;
        $pdf = PDF::loadView('print_roster_admin', ['roster' => $rosterRes, 'divers' => $divers, 'totals' => $totals])->setPaper('a4');
        $rosterType = 'Amministrativo';
        $filename = "Roster " . $rosterType . " del " . date('dmY-Hi', strtotime($roster->date)) . ".pdf";
        return $pdf->stream($filename);
    }
    public function printTech(Request $request, Roster $roster)
    {
        //$rRes = new RosterResource($roster);
        $rosterRes = json_decode(json_encode(new RosterResource($roster)));
        $missingActivities = [];
        $nextActivities = [];
        $activityType = "CW";
        switch ($roster->type) {
            case "POOL":
                $activityType = "CW";
                break;
            case "DIVE":
                $activityType = "OW";
                break;
            case "THEORY":
                $activityType = "THEORY";
                break;
            default:
                $activityType = "CW";
        }
        $activityName = "Acqua confinata";
        switch ($activityType) {
            case "CW":
                $activityName = "Acqua confinata";
                break;
            case "OW":
                $activityName = "Acqua libera";
                break;
            case "THEORY":
                $activityName = "Teoria";
                break;
            default:
                $activityName = "Acqua confinata";
        }
        $activityTypeName = $activityName;
        if (isset($rosterRes->dives[0]))
            foreach ($rosterRes->dives[0]->divers as $idx => $rosterCourse) {
                if (count($rosterCourse->divers) <= 0) {
                    unset($rosterRes->divers[$idx]);
                    continue;
                }

                if (!$rosterCourse->course_id || $rosterCourse->course_id == 'GUESTS') {
                    unset($rosterRes->divers[$idx]);
                    continue;
                }

                $course = Course::with('users')->find($rosterCourse->course_id);

                if (!$course)
                    dd($rosterCourse->course_id);
                $courseName
                    = $course->certification->name . ' ' . $course->number . '/' . $course->start_date->format('Y');
                $nextSessions[$courseName] = null;
                foreach ($course->users as $student) {
                    if ($student->pivot->teaching)
                        continue;

                    foreach ($student->pivot->progress as $progress) {

                        if ($progress['label'] != $activityType)
                            continue;
                        $studentName = $student->lastname . " " . $student->firstname;
                        foreach ($progress['values'] as $session) {

                            $missings = [];
                            $allCompleted = true;
                            $activityCount = 0;
                            $this->searchMissingActivities($session['values'], $missings, $activityCount);
                            $sessionName = isset($session['label']) && $session['label'] ? $session['label'] : $activityName . " " . $session['order'];

                            $missingActivities[$courseName][$studentName][$activityType][$sessionName]['order'] = $session['order'];
                            $missingActivities[$courseName][$studentName][$activityType][$sessionName]['missings'] = $missings;

                            $missingActivities[$courseName][$studentName][$activityType][$sessionName]['completed'] = count($missings) === 0;
                            $missingActivities[$courseName][$studentName][$activityType][$sessionName]['started'] =
                                count($missings) < $activityCount;
                            $nextSessions[$courseName][$activityType] = 0;
                        }
                    }
                }
            }

        foreach ($missingActivities as $courseName => $student) {
            foreach ($student as $studentName => $activity) {
                foreach ($activity as $activityType => $session) {
                    $found = 0;
                    $count = 0;
                    foreach ($session as $idx => $values) {

                        if (!$values['started']) {
                            $found = $values['order'];
                            $nextFound = false;
                            foreach (array_slice($session, $count) as $idn => $next) {
                                if ($next['started']) {
                                    $nextFound = true;
                                    $found = 0;
                                }
                            }
                            if (!$nextFound)
                                break;
                        }
                        $count++;
                    }
                    if ($found == 0) $found = 9999;
                    if ($found > $nextSessions[$courseName][$activityType])
                        $nextSessions[$courseName][$activityType] = $found;
                }
            }
            if (!isset($nextSessions[$courseName][$activityType]) || !$nextSessions[$courseName][$activityType])
                $nextSessions[$courseName][$activityType] = 1;
            //$nextSessions[$courseName][$activityType]++;
        }
        $nextActivities = [];

        foreach ($missingActivities as $courseName => $student) {
            foreach ($student as $studentName => $activity) {
                foreach ($activity as $activityType => $session) {
                    $nextActivities[$courseName][$activityType]['overall'] = $nextSessions[$courseName][$activityType];
                    $next
                        = $nextSessions[$courseName][$activityType];

                    foreach ($session as $sessionName => $values) {
                        if ($values['order'] >= $next)
                            continue;
                        $nextActivities[$courseName][$activityType]['students'][$studentName][$sessionName]['completed'] = $values['completed'];
                        if (!$values['completed']) {
                            $nextActivities[$courseName][$activityType]['students'][$studentName][$sessionName]['missings'] = !$values['started'] ? ["Tutti"]  : $values['missings'];
                        } else
                            $nextActivities[$courseName][$activityType]['students'][$studentName][$sessionName]['missings'] = [];
                    }
                }
            }
        }
        foreach ($nextActivities as $courseName => $activities) {
            foreach ($activities as $activityType => $students) {
                if (!isset($nextActivities[$courseName][$activityType]['students']) || !$nextActivities[$courseName][$activityType]['students']) {
                    $nextActivities[$courseName][$activityType]['students'] = [];
                    continue;
                }
                ksort($nextActivities[$courseName][$activityType]['students']);
            }
        }
        ksort($nextActivities);


        //return view('print_roster_tech', ['roster' => $rosterRes, 'nextActivities' => $nextActivities, 'activityType' => $activityType, 'activityTypeName' => $activityTypeName]);

        $pdf = PDF::loadView('print_roster_tech', ['roster' => $rosterRes, 'nextActivities' => $nextActivities, 'activityType' => $activityType, 'activityTypeName' => $activityTypeName])->setPaper('a4');
        $rosterType = 'Tecnico';
        $filename = "Roster " . $rosterType . " del " . date('dmY-Hi', strtotime($roster->date)) . ".pdf";
        return $pdf->stream($filename);
    }
    private function searchMissingActivities($array, &$missings, &$activityCount)
    {
        foreach ($array as $idx => $item) {

            if (isset($item['values'])) {
                if (!isset($item['values'][0]['values'])) {
                    $done = 0;
                    foreach ($item['values'] as $exercise) {
                        $activityCount++;
                        if (!$exercise['date']) {
                            $missings[] = $exercise;
                        }
                    }
                }
                $this->searchMissingActivities($item['values'], $missings, $activityCount);
            }
        }
    }
}
