<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiveSitePostRequest;
use App\Http\Requests\DivingPostRequest;
use App\Http\Resources\DiveSiteResource;
use App\Models\DiveSite;
use App\Models\Diving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DiveSiteController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->user()->isAbleTo('view-all'))
            return response('unauthorized', 403);
        $sort = $request->get('sort', 'name');
        $sortDirection = $request->get('sortDirection', 'ASC');
        $search = $request->get('search', '');

        return DiveSiteResource::collection(DiveSite::where('name', 'LIKE', '%' . $search . '%')->orderBy($sort, $sortDirection)->jsonPaginate());
    }
    public function indexAll(Request $request)
    {
        if (!$request->user()->isAbleTo('view-all'))
            return response('unauthorized', 403);
        return response()->json(DiveSite::orderBy('name', 'ASC')->get());
    }
    public function get(Request $request, DiveSite $site)
    {
        if ($request->user()->isAbleTo('view-all')) {
            return new DiveSiteResource($site);
        } else return response('unauthorized', 403);
    }

    public function getAvailables(Request $request)
    {
        if (!$request->user()->isAbleTo('view-all'))
            return response('unauthorized', 403);
        $excluded = $request->get('exclude', null);
        $sites = DiveSite::whereNotIn('id', explode('|', $excluded))->orderBy('name')->get();
        return DiveSiteResource::collection($sites);
    }
    public function update(DiveSitePostRequest $request, DiveSite $site)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();
            $site->fill($request->safe()->toArray());


            $site->save();
            return new DiveSiteResource($site);
        } else return response('unauthorized', 403);
    }

    public function store(DiveSitePostRequest $request)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();
            $data = $request->safe()->toArray();

            $site = DiveSite::create($data);
            $site->save();

            return new DiveSiteResource($site);
        } else return response('unauthorized', 403);
    }
    public function destroy(Request $request, DiveSite $site)
    {
        if ($request->user()->isAbleTo('delete-all')) {

            $site->delete();
            return response()->json(['status' => 'deleted']);
        } else return response('unauthorized', 403);
    }
}
