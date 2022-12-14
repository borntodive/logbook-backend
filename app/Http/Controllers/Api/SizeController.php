<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SizeController extends Controller
{
     public function index(Request $request)
    {
        $sizes=Size::get();
        return response()->json($sizes);
    }
}
