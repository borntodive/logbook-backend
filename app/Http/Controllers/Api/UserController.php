<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'lastname');
        $sortDirection = $request->get('sortDirection', 'ASC');
        $search=$request->get('search', '');
        return User::search($search,['firstname','lastname'])->orderBy($sort,$sortDirection)->jsonPaginate();
    }
    public function get(Request $request, $user_id)
    {
        $user=User::with('equipments')->findOrFail($user_id);
        return response()->json($user);
    }
}
