<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    function login(Request $request) {
        $validator = validator()->make($request->all(), ["email" =>
            'required', 'email',
            'password' => 'required'
        ]);  
        if($validator->fails()){
            //return $validator->errors();
            return response()->json($validator->errors(),422);
        }
        $credentials = $validator->validated();
       
        if(Auth::attempt($credentials)){
            // session()->regenerate(); // SPA con COOKIE
            // return response()->json('Successful authentication'); // SPA con COOKIE
            // dd(auth()->user()->createToken('myapptoken'));
            $token = auth()->user()->createToken('myapptoken')->plainTextToken;
            return response()->json($token);
            
        }else{
            return response()->json('Invalid credentials',401);
        }
        
    }

    function logout(string $tokenId)  {
        // // Revoke all tokens...
        // $user->tokens()->delete();
        // Revoke a specific token...
        $user->tokens()->where('id', $tokenId)->delete();
    }
}