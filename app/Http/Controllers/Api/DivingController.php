<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\DivingPostRequest;
use App\Http\Resources\DiveSiteResource;
use App\Http\Resources\DivingResource;
use App\Models\Diving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            $diving->fill($request->safe()->except(['logoName']));

            $logoName = $request->logoName;

            if ($logoName && Storage::exists('public/tmp/' . $logoName)) {
                Storage::move('public/tmp/' . $logoName, 'public/images/divings/' . $logoName);
                $diving->logo = $logoName;
            }
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
    public function uploadLogo(Request $request)
    {
        if (!$request->user()->isAbleTo('edit-all'))
            return response('unauthorized', 403);

        $file = $request->file('logo');
        if ($file) {
            $name = uniqid() . '.' . trim($file->getClientOriginalExtension());
            $path = $request->file('logo')->storeAs(
                'public/tmp',
                $name
            );

            return response()->json(['name' => $name, 'tempSrc' => Storage::url('tmp/' . $name)]);
        }
        return response()->json(['message' => 'error'], 405);
    }
    public function destroyLogo(Request $request, Diving $diving)
    {
        if (!$request->user()->isAbleTo('edit-all'))
            return response('unauthorized', 403);


        $diving->logo = null;
        $diving->save();
        return response()->json(['message' => 'success', 'tempSrc' => $diving->getLogoUrl()]);
    }

    public function addSite(Request $request, Diving $diving, $site_id)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $diving->sites()->attach(
                $site_id
            );
            return response()->json(['message' => 'success']);
        } else return response('unauthorized', 403);
    }
    public function destoySite(Request $request, Diving $diving, $site_id)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $diving->sites()->detach(
                $site_id
            );
            return response()->json(['message' => 'success']);
        } else return response('unauthorized', 403);
    }
}
