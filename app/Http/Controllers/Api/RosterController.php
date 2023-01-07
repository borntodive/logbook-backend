<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RosterDiverPostRequest;
use App\Http\Requests\RosterPostRequest;
use App\Http\Resources\RosterResource;
use App\Models\Course;
use App\Models\Equipment;
use App\Models\Roster;
use App\Models\RosterUser;
use App\Models\Size;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

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
            $data = $request->safe()->toArray();
            $roster = Roster::create($data);


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
            $data = $request->safe()->toArray();
            $roster->fill($data);

            $roster->save();

            return new RosterResource($roster);
        } else return response('unauthorized', 403);
    }
    public function updateDiver(RosterDiverPostRequest $request, Roster $roster, $diver_id)
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
                $u->equipments()->detach();
                foreach ($data['gears'] as $id => $equipment) {
                    $u->equipments()->attach($equipment['equipment_id'], ['number' => $equipment['number'], 'size_id' => $equipment['size_id']]);
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

    public function addUser(Request $request, Roster $roster, User $user)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $course_id = $request->input('course_id');
            if (!$course_id || $course_id == 'GUESTS')
                $course_id = null;
            $roster->users()->attach($user->id, ['course_id' => $course_id, 'gears' => $user->getDefaultSizes(), 'price' => $user->duty->name == 'Diver' ? $roster->price : $roster->cost]);
            return response()->json(['status' => 'success']);
        } else return response('unauthorized', 403);
    }
    public function addCourse(Request $request, Roster $roster, Course $course)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            foreach ($course->users as $user) {
                try {
                    $roster->users()->attach($user->id, ['course_id' => $course->id, 'gears' => $user->getDefaultSizes(), 'price' => $user->duty->name == 'Diver' ? $roster->price : $roster->cost]);
                } catch (Exception $e) {
                }
            }
            return response()->json(['status' => 'success']);
        } else return response('unauthorized', 403);
    }
    public function destroyCourse(Request $request, Roster $roster, $course_id)
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

    public function destroyUser(Request $request, Roster $roster, $user_id)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $roster->users()->detach($user_id);
            return response()->json(['status' => 'success']);
        } else return response('unauthorized', 403);
    }
}
