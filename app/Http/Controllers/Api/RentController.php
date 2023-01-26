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
use PDF;

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

        return MinimalRentResource::collection($rents->jsonPaginate());
    }
    public function getByUser(Request $request, $user_id)
    {

        if ($request->user()->isAbleTo('view-all') || $request->user()->id == $user_id) {

            $sort = $request->get('sort', 'start_date');
            $sortDirection = $request->get('sortDirection', 'ASC');
            $search = $request->get('search', '');
            $filter = $request->get('filter', 'open');

            $rents = Rent::select('rents.*')->whereHas('user', fn ($query) => $query->where('id', '=', $user_id))->orderBy('start_date', $sortDirection)
                ->orderBy('number', $sortDirection);
            if ($filter == 'open')
                $rents = $rents->where('rents.return_date', null)->where('rents.start_date', '<=', now());
            if ($filter == 'closed')
                $rents = $rents->where('rents.return_date', '<>', null);
            if ($filter == 'future')
                $rents = $rents->whereNull('rents.return_date')->where('rents.start_date', '>', now());
            return MinimalRentResource::collection($rents->jsonPaginate());
        } else return response('unauthorized', 403);
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
    public function printAgreement(Request $request, Rent $rent)
    {
        //$rRes = new RosterResource($roster);
        $rentRes = json_decode(json_encode(new RentResource($rent)));
        $translations =
            [
                "sizes" => [
                    "xxxs" => "XXXS",
                    "xxs" => "XXS",
                    "xs" => "XS",
                    "s" => "S",
                    "m" => "M",
                    "lg" => "L",
                    "xl" => "XL",
                    "xxl" => "XXL",
                    "uni" => "UNI",
                    "4L" => "4L",
                    "5L" => "5L",
                    "7L" => "7L",
                    "10L" => "10L",
                    "11L" => "11L",
                    "12L" => "12L",
                    "15L" => "15L",
                    "18L" => "18L",
                    "B10L" => "10+10L",
                    "B12L" => "12+12L",
                    "HOGA" => "HOGA",
                    "OCTO" => "OCTO",
                    "2REG" => "2ERO",
                    "3P" => "3P",
                    "4P" => "4P",
                    "5P" => "5P",
                    "6P" => "6P",
                    "xxxsm" => "XXXS-M",
                    "xxsm" => "XXS-M",
                    "xsm" => "XS-M",
                    "sm" => "S-M",
                    "mm" => "M-M",
                    "lgm" => "L-M",
                    "xlm" => "XL-M",
                    "xxlm" => "XXL-M",
                    "xxxsf" => "XXXS-F",
                    "xxsf" => "XXS-F",
                    "xsf" => "XS-F",
                    "sf" => "S-F",
                    "mf" => "M-F",
                    "lgf" => "L-F",
                    "xlf" => "XL-F",
                    "xxlf" => "XXL-F",
                    "O.5" => "0.5",
                    "1",
                    "1.5" => "1.5",
                    "2",
                    "2.5" => "2.5",
                    "3",
                    "3.5" => "3.5",
                    "4"
                ],
                "inventory" => [
                    "recreational" => "Ricreativo",
                    "technical" => "Tecnico",
                    "pool" => "Piscina",
                    "dive" => "Immersione",
                    "dry" => "Stagna",
                    "strap" => "Cinghiolo",
                    "footpoket" => "A scarpetta",
                    "classic" => "Classica",
                    "pockets" => "A tasche",
                    "aluminum" => "Alluminio",
                    "iron" => "Acciaio"
                ],
                "equipments" => [
                    "suit" => "Muta",
                    "bcd" => "GAV",
                    "boot" => "Calzari",
                    "fins" => "Pinne",
                    "mask" => "Maschera",
                    "weightsBelt" => "Cintura pesi",
                    "regulator" => "Erogatore",
                    "weight" => "Pesi",
                    "tank" => "Bombola"
                ]
            ];;
        //return view('print_rent_agreement', ['rent' => $rentRes, 'translations' => $translations]);

        $pdf = PDF::loadView('print_rent_agreement', ['rent' => $rentRes, 'translations' => $translations])->setPaper('a4');
        $filename = "Contratto noleggio " . $rentRes->name . " del " . date('dmY', strtotime($rentRes->startDate)) . ".pdf";
        return $pdf->stream($filename);
    }
}
