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


class RosterController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->isAbleTo('view-all'))
            return response('unauthorized', 403);
        $sort = $request->get('sort', 'date');
        $type = $request->get('type', 'POOL');
        $sortDirection = $request->get('sortDirection', 'ASC');
        $rosters = Roster::where('type', $type)->orderBy($sort, $sortDirection);
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

            $roster->users()->detach();
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
            return response()->json(['status' => 'success']);
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
            return response()->json(['status' => 'success']);
        } else return response('unauthorized', 403);
    }
    public function addDive(RosterDivePostRequest $request, Roster $roster)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();
            $roster->roster_dives()->create($request->safe()->toArray());
            return response()->json(['status' => 'success']);
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
            return response()->json(['status' => 'success']);
        } else return response('unauthorized', 403);
    }

    public function addUser(Request $request, RosterDive $roster, User $user)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $course_id = $request->input('course_id');
            if (!$course_id || $course_id == 'GUESTS')
                $course_id = null;

            $roster->users()->attach($user->id, ['course_id' => $course_id, 'gears' => $user->getDefaultSizes(), 'price' => $user->duty->name == 'Diver' ? $roster->price : $roster->cost]);
            return response()->json(['status' => 'success']);
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
            return response()->json(['status' => 'success']);
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
            return response()->json(['status' => 'success']);
        } else return response('unauthorized', 403);
    }

    public function destroyDive(Request $request, RosterDive $roster)
    {
        if ($request->user()->isAbleTo('edit-all')) {

            $roster->users()->detach();
            $roster->delete();
            return response()->json(['status' => 'success']);
        } else return response('unauthorized', 403);
    }
    public function destroyUser(Request $request, RosterDive $roster, $user_id)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $roster->users()->detach($user_id);
            return response()->json(['status' => 'success']);
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
                    "xxs": "XXS",
                    "xs": "XS",
                    "s": "S",
                    "m": "M",
                    "lg": "L",
                    "xl": "XL",
                    "xxl": "XXL",
                    "uni": "UNI",
                    "4L": "4L",
                    "7L": "7L",
                    "10L": "10L",
                    "11L": "11L",
                    "12L": "12L",
                    "15L": "15L",
                    "B10L": "10+10L",
                    "B12L": "12+12L"
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
        $rosterRes = json_decode(json_encode(new RosterResource($roster)));

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
                    $divers[$diver->id]['balance']['dive'] += $diver->price;
                    if (isset($diver->courseData) && $diver->courseData && !$diver->teaching) {
                        $divers[$diver->id]['balance']['course'] += $diver->courseData->price - $diver->courseData->payment_1 - $diver->courseData->payment_2 - $diver->courseData->payment_3;
                        $totals['course']['income']  +=
                            $diver->courseData->price - $diver->courseData->payment_1 - $diver->courseData->payment_2 - $diver->courseData->payment_3;
                    }
                    $divers[$diver->id]['balance']['equipment'] = 0;
                    $totals['equipment']['income']  = 0;

                    $divers[$diver->id]['balance']['total'] = $divers[$diver->id]['balance']['dive'] + $divers[$diver->id]['balance']['equipment'] + $divers[$diver->id]['balance']['course'];
                    $totals['dive']['income'] += $diver->price;

                    $totals['equipment']['income']  += 0;
                }
            }
            $totals['dive']['cost'] += $dive->cost * $totalDivers - $dive->cost * $rosterRes->gratuities;
        }
        $view = view('print_roster_admin', ['roster' => $rosterRes, 'divers' => $divers, 'totals' => $totals])->render();
        //return $view;
        $pdf = PDF::loadView('print_roster_admin', ['roster' => $rosterRes, 'divers' => $divers, 'totals' => $totals])->setPaper('a4');
        $rosterType = 'Amministrativo';
        $filename = "Roster " . $rosterType . " del " . date('dmY-Hi', strtotime($roster->date)) . ".pdf";
        return $pdf->stream($filename);
        $pdf = new PdfT;
        $pdf->addPage($view);
        if (!$pdf->send()) {
            dd($pdf->getError());
            // ... handle error here
        }
        //return Browsershot::url('https://google.com')->noSandbox()->timeout(360)->save('your.pdf');
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
                            $sessionName = isset($session['label']) && $session['label'] ? $session['label'] : $activityName . " " . $session['order'];
                            $missingActivities[$courseName][$studentName][$activityType][$sessionName]['order'] = $session['order'];
                            $missingActivities[$courseName][$studentName][$activityType][$sessionName]['missings'] = $missings;
                            $missingActivities[$courseName][$studentName][$activityType][$sessionName]['completed'] = count($missings) === 0;
                            $missingActivities[$courseName][$studentName][$activityType][$sessionName]['neverStarted'] =
                                count($missings) === $activityCount;
                            $nextSessions[$courseName][$activityType] = 0;
                        }
                    }
                }
            }
        foreach ($missingActivities as $courseName => $student) {
            foreach ($student as $studentName => $activity) {
                foreach ($activity as $activityType => $session) {
                    $keys = array_keys($session);
                    foreach (array_keys($keys) as $sessionKey) {
                        $sessionName = current($keys);
                        $values = $session[$sessionName];
                        if (
                            $values['completed'] && $values['order'] > $nextSessions[$courseName][$activityType]
                        ) {
                            $nextSessionName = next(($keys));
                            if ($nextSessionName) {
                                $nextValues
                                    = $session[$nextSessionName];
                                if (count($nextValues['missings']))
                                    $nextSessions[$courseName][$activityType] = $nextValues['order'];
                                else
                                    $nextSessions[$courseName][$activityType] = $values['order'];
                            } else
                                $nextSessions[$courseName][$activityType] = $values['order'];
                        }
                    }
                }
            }
            $nextSessions[$courseName][$activityType]++;
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
                        if (!$values['completed']) {
                            $nextActivities[$courseName][$activityType]['students'][$studentName][$sessionName]['missings'] = $values['neverStarted'] ? ["Tutti"]  : $values['missings'];
                        }
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


        // return view('print_roster_tech', ['roster' => $rosterRes, 'nextActivities' => $nextActivities, 'activityType' => $activityType, 'activityTypeName' => $activityTypeName]);

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
