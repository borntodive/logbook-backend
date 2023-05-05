<?php

namespace App\Helpers;

use App\Models\Inventory;
use App\Models\Rent;
use App\Models\RentEquipment;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;


class InventoryHelper
{
    private $equipment;


    public function __construct(Inventory $equipment = null)
    {
        $this->equipment = $equipment;
    }

    public function checkEquipmentsAvailability()
    {
        $items = [];
        foreach ($this->equipment->items as $item) {
            $availability = $this->checkItemAvailability($item['code']);
            $items[] = [
                'code'      => $item['code'],
                'available' => $availability
            ];
        }
        return $items;
    }

    public function checkItemAvailability($code, $rent = null)
    {
        if (!$rent) {
            return RentEquipment::whereHas('rent', function ($q) {
                $q->where('start_date', '<=', now())->where('return_date', null);
            })->where('code', $code)->first() ? false : true;
        } else {

            return
                RentEquipment::whereHas('rent', function ($q) use ($rent) {
                    $q->where('start_date', '<=', $rent->start_date)->where('return_date', null);
                })->where('code', $code)->first() ? false : true;

            //return $pastAvail || $futureAvail ? false : true;
        }
    }
}
