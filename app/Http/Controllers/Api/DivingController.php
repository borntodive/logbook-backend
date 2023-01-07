<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Diving;
use Illuminate\Http\Request;

class DivingController extends Controller
{
    public function index(Request $request)
    {
        return response()->json(Diving::get());
    }
}
