<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EquipmentResource;
use App\Http\Resources\InventoryResource;
use App\Models\Equipment;
use App\Models\EquipmentType;
use App\Models\Inventory;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


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
    public function addSize(Request $request, Equipment $equipment)
    {
        if (!$request->user()->isAbleTo('manage-gears'))
            return response('unauthorized', 403);
        $size = Size::where('name', $request->input('size'))->firstOrFail();
        $type = EquipmentType::where('name', $request->input('type'))->firstOrFail();

        $invertory = Inventory::firstOrCreate(['equipment_id' => $equipment->id, 'equipment_type_id' => $type->id, 'size_id' => $size->id]);
        $items = $invertory->items;
        $code = sprintf("%06d", mt_rand(1, 999999));
        $items[] =
            [
                'code'      => $this->checkCodeAvailability($code),
                'available' => true,
            ];
        $invertory->items = $items;
        $invertory->save();
        return response()->json(['message' => 'success']);
    }

    private function checkCodeAvailability($code)
    {
        $eq = Inventory::whereJsonContains('items', [['code' => $code]])->first();
        if ($eq) {
            $this->checkCodeAvailability(sprintf("%06d", mt_rand(1, 999999)));
        }
        return $code;
    }
    public function destroy(Request $request, $code)
    {
        if (!$request->user()->isAbleTo('manage-gears'))
            return response('unauthorized', 403);
        $eq = Inventory::whereJsonContains('items', [['code' => $code]])->first();
        $oldItems = $eq->items;
        foreach ($oldItems as $id => $item) {
            if ($item['code'] == $code) {
                unset($oldItems[$id]);
                break;
            }
        }
        $eq->items = array_values($oldItems);
        $eq->save();
        return response()->json(['message' => 'success']);
    }
}
