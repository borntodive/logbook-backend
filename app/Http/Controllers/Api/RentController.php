<?php

namespace App\Http\Controllers\Api;

use App\Helpers\InventoryHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\RentPostRequest;
use App\Http\Resources\CourseResource;
use App\Http\Resources\MinimalRentResource;
use App\Http\Resources\RentResource;
use App\Models\Rent;
use App\Models\RentEquipment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RentController extends Controller
{

    public function index(Request $request)
    {
        if (!$request->user()->isAbleTo('view-all'))
            return response('unauthorized', 403);
        $sort = $request->get('sort', 'start_date');
        $sortDirection = $request->get('sortDirection', 'ASC');
        $search = $request->get('search', '');
        $filter = $request->get('filter', 'open');

        $rents = Rent::select('rents.*')->orderBy('start_date', $sortDirection)
            ->orderBy('number', $sortDirection);
        if ($filter == 'open')
            $rents = $rents->where('rents.return_date', null)->where('rents.start_date', '<=', now());
        if ($filter == 'closed')
            $rents = $rents->where('rents.return_date', '<>', null);
        if ($filter == 'future')
            $rents = $rents->whereNull('rents.return_date')->where('rents.start_date', '>', now());
        /*  $rents = $rents->join(
            'users',
            function ($join) use ($search) {
                $join->on('users.id', '=', 'rents.user_id')
                    ->where('users.firstname', 'like', '%' . $search . '%')
                    ->orWhere('users.lastname', 'like', '%' . $search . '%');
            }
        ); */
        return MinimalRentResource::collection($rents->jsonPaginate());
    }
    public function store(RentPostRequest $request)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();
            $data = $request->safe()->toArray();
            $cYear = Carbon::parse($data['start_date'])->format('Y');

            $latestRent = Rent::whereYear('start_date', $cYear)->orderBy('number', 'DESC')->first();
            $data['number'] = 1;
            if ($latestRent)
                $data['number'] = $latestRent->number + 1;
            $rent = Rent::create($data);

            return new RentResource($rent);
        } else return response('unauthorized', 403);
    }

    public function get(Request $request, Rent $rent)
    {
        if ($request->user()->isAbleTo('view-all')) {
            return new RentResource($rent);
        } else return response('unauthorized', 403);
    }


    public function update(RentPostRequest $request, Rent $rent)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $validated = $request->validated();
            $data = $request->safe()->toArray();


            $rent->fill($data);

            $rent->save();


            return new RentResource($rent);
        } else return response('unauthorized', 403);
    }

    public function addEquipment(Request $request, Rent $rent)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $code = $request->code;
            $brand = $request->brand;
            $otherEq = RentEquipment::where('rent_id', $rent->id)->where('code', $code)->first();
            $invHelper = new InventoryHelper();
            if ($invHelper->checkItemAvailability($code, $rent) && !$otherEq) {
                $e = RentEquipment::create(['rent_id' => $rent->id, 'code' => $code, 'brand' => $brand]);
                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['message' => 'NOTAVAILABLE']);
            }
        } else return response('unauthorized', 403);
    }
    public function destroyEquipment(Request $request, $code)
    {
        if ($request->user()->isAbleTo('edit-all')) {
            $item = RentEquipment::where('code', $code)->firstOrFail();
            $item->delete();
            return response()->json(['message' => 'success']);
        } else return response('unauthorized', 403);
    }

    public function destroy(Request $request, Rent $rent)
    {
        if ($request->user()->isAbleTo('delete-all')) {
            $rent->delete();
            return response()->json(['message' => 'success']);
        } else return response('unauthorized', 403);
    }
}
