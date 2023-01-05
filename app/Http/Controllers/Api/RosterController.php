<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\RosterResource;
use App\Models\Roster;
use Illuminate\Http\Request;

class RosterController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->isAbleTo('view-all-rosters'))
            return response('unauthorized', 403);
        $sort = $request->get('sort', 'date');
        $type = $request->get('type', 1);
        $sortDirection = $request->get('sortDirection', 'ASC');
        $rosters = Roster::where('type', $type)->orderBy($sort, $sortDirection);
        return RosterResource::collection($rosters->jsonPaginate());
    }
    public function destroy(Request $request, Roster $roster)
    {
        if ($request->user()->isAbleTo('delete_roster')) {

            // $roster->users()->detach();
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
}
