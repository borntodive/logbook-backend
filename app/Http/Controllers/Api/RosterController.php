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
use Illuminate\Http\Request;

class RosterController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->isAbleTo('view-all-rosters'))
            return response('unauthorized', 403);
        $sort = $request->get('sort', 'date');
        $type = $request->get('type', 'POOL');
        $sortDirection = $request->get('sortDirection', 'ASC');
        $rosters = Roster::where('type', $type)->orderBy($sort, $sortDirection);
        return RosterResource::collection($rosters->jsonPaginate());
    }
    public function destroy(Request $request, Roster $roster)
    {
        if ($request->user()->isAbleTo('delete_roster')) {

            $roster->users()->detach();
            $roster->delete();
            return response()->json(['status' => 'deleted']);
        } else return response('unauthorized', 403);
    }

    public function get(Request $request, Roster $roster)
    {
        if ($request->user()->isAbleTo('view-all-rosters')) {
            return new RosterResource($roster);
        } else return response('unauthorized', 403);
    }

    public function update(RosterPostRequest $request, Roster $roster)
    {
        if ($request->user()->isAbleTo('edit_course')) {
            $validated = $request->validated();
            $data = $request->safe()->toArray();
            $roster->fill($data);

            $roster->save();

            return new RosterResource($roster);
        } else return response('unauthorized', 403);
    }
    public function updateDiver(RosterDiverPostRequest $request, Roster $roster, $diver_id)
    {
        if ($request->user()->isAbleTo('edit_course')) {
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
}
