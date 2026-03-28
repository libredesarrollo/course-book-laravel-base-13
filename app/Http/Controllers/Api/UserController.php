<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $credentials = $validator->validated();

        if (Auth::attempt($credentials)) {
            $token = auth()->user()->createToken('myapptoken')->plainTextToken;

            return response()->json($token);
        }

        return response()->json('Invalid credentials', 401);
    }

    public function logout(Request $request, string $tokenId)
    {
        $request->user()->tokens()->where('id', $tokenId)->delete();
           return response()->json([
                'message' => 'Token deleted correctamente'
            ], 204);
    }
}
