<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\LoginResource;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response(['errors' => $validator->errors()->all()], 422);
        }
        $user = User::with('roles')->where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {

                return new LoginResource($user);

            } else {
                $response = ['message' => 'Not Found'];

                return response($response, 404);
            }
        } else {
            $response = ['message' => 'Not Found'];

            return response($response, 404);
        }
    }
     public function logout(Request $request)
    {
        $user=$request()->auth()->user();
        $user->tokens()->delete();
    }
}
