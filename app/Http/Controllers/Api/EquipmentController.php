<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
     public function index(Request $request)
    {
        return response()->json(Equipment::with('sizes')->get());
    }
}
