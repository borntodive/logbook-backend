<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DivingPostRequest;
use App\Http\Resources\DivingResource;
use App\Models\Diving;
use Illuminate\Http\Request;

class DivingController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->isAbleTo('view-all'))
            return response('unauthorized', 403);
        $sort = $request->get('sort', 'name');
        $sortDirection = $request->get('sortDirection', 'ASC');
        $search = $request->get('search', '');

        return DivingResource::collection(Diving::where('name', 'LIKE', '%' . $search . '%')->orderBy($sort, $sortDirection)->jsonPaginate());
    }
    public function indexAll(Request $request)
    {
        if (!$request->user()->isAbleTo('view-all'))
            return response('unauthorized', 403);
        return response()->json(Diving::get());
    }
    public function get(Request $request, Diving $diving)
    {
        if ($request->user()->isAbleTo('view-all')) {
            return new DivingResource($diving);
        } else return response('unauthorized', 403);
    }
    public function update(DivingPostRequest $request, Diving $diving)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();
            $diving->fill($request->safe()->toArray());
            $diving->save();

            return new DivingResource($diving);
        } else return response('unauthorized', 403);
    }

    public function store(DivingPostRequest $request)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();
            $data = $request->safe()->toArray();

            $diving = Diving::create($data);
            $diving->save();

            return new DivingResource($diving);
        } else return response('unauthorized', 403);
    }
    public function destroy(Request $request, Diving $diving)
    {
        if ($request->user()->isAbleTo('delete-all')) {

            $diving->rosters()->detach();
            $diving->delete();
            return response()->json(['status' => 'deleted']);
        } else return response('unauthorized', 403);
    }
}
