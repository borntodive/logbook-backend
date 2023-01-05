<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Roster;
use Illuminate\Http\Request;

class RosterController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->isAbleTo('view_all_rosters'))
            return response('unauthorized', 403);
        $sort = $request->get('sort', 'date');
        $sortDirection = $request->get('sortDirection', 'ASC');
        $search = $request->get('search', '');
        $courses = Roster::orderBy('certifications.name', $sortDirection)
            ->orderBy('start_date', $sortDirection)
            ->orderBy('number', $sortDirection);
        //return CourseResource::collection($courses->jsonPaginate());
    }
}
