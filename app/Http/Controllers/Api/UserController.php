<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPostRequest;
use App\Models\Equipment;
use App\Models\Size;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $sort = $request->get('sort', 'lastname');
        $sortDirection = $request->get('sortDirection', 'ASC');
        $search=$request->get('search', '');

        return UserResource::collection(User::search($search,['firstname','lastname'])->orderBy($sort,$sortDirection)->jsonPaginate());
    }
    public function get(Request $request, $user_id)
    {
        $user=User::with('equipments')->findOrFail($user_id);
        return new UserResource(User::with('equipments')->findOrFail($user_id));
    }

    public function update(UserPostRequest $request, User $user)
    {
        $validated = $request->validated();
        $user->fill($request->safe()->except(['equipments']));
        $user->save();
         $equipments=$request->safe()->only(['equipments']);
$user->equipments()->detach();
         foreach ($equipments['equipments'] as $id=>$equipment) {
            $eq=Equipment::where('name',$equipment['equipment'])->first();
            if (is_numeric($equipment['size'])) {
                $user->equipments()->attach($eq->id,['number'=>$equipment['size']]);

            }
            else {
                $size=Size::where('name',$equipment['size'])->first();
                $user->equipments()->attach($eq->id,['size_id'=>$size->id]);
            }
         }
        return new UserResource($user);
    }

    public function store(UserPostRequest $request)
    {
        $validated = $request->validated();
        $data=$request->safe()->except(['equipments']);
        $password=uniqid();
        $data['password']=Hash::make($password);
        $user=User::create($data);
        $user->save();
         $equipments=$request->safe()->only(['equipments']);
        $user->equipments()->detach();
         foreach ($equipments['equipments'] as $id=>$equipment) {
            $eq=Equipment::where('name',$equipment['equipment'])->first();
            if (is_numeric($equipment['size'])) {
                $user->equipments()->attach($eq->id,['number'=>$equipment['size']]);

            }
            else {
                $size=Size::where('name',$equipment['size'])->first();
                $user->equipments()->attach($eq->id,['size_id'=>$size->id]);
            }
         }
        return new UserResource($user);    }
}
