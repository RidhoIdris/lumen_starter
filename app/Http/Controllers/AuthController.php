<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\User;
use Dingo\Api\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login']]);
    }

    public function login(Request $request)
    {
       $credentials = $request->only('email', 'password');
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json(['status' => 'Email or Password is Wrong'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(Auth::user());
    }

    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token'  => $token,
            'user_data'     => Auth::user(),
            'token_type'    => 'bearer',
            'expires_in'    => Auth::factory()->getTTL() * 60
        ]);
    }
}