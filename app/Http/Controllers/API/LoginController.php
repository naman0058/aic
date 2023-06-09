<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
	{
		$credentials = $request->only('email', 'password');
		if (auth()->attempt($credentials)) {
			$token = auth()->user()->createToken('authToken')->accessToken;
			$user=auth()->user()->only(['id','name','email']);
			return response()->json(['token' => $token,'user'=>$user], 200);
		} else {
			return response()->json(['error' => 'Unauthenticated'], 401);
		}
	}
	public function logout()
	{
		auth()->user()->token()->revoke();																					
		return response()->json(['message' => 'Successfully logged out']);
	}
	public function user()
	{
		 //
	}
}
