<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\InventoryResource;
use App\Models\Equipment;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function get(Request $request, Equipment $equipment)
    {
        if (!$request->user()->isAbleTo('manage-gears'))
            return response('unauthorized', 403);
        return new InventoryResource($equipment);
    }
    public function index(Request $request)
    {
        if (!$request->user()->isAbleTo('manage-gears'))
            return response('unauthorized', 403);
        $sort = $request->get('sort', 'name');
        $sortDirection = $request->get('sortDirection', 'ASC');
        $search = $request->get('search', '');
        return EquipmentResource::collection(Equipment::jsonPaginate());
    }
}
