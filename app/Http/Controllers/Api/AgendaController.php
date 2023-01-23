<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\AgendaResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Roster;
use App\Models\User;

class AgendaController extends Controller
{
    public function index(Request $request)
    {

        $user = User::findOrFail($request->user()->id);
        //dd(AgendaResource::collection($user->rosters()->jsonPaginate()));
        return new AgendaResource($user->rosters()->jsonPaginate());
    }
}
