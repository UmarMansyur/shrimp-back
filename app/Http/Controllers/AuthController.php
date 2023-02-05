<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['except' => ['login', 'logout', 'refresh']]);
    }

    public function login(Request $request)
    {
        try {
            $this->validate(
                $request,
                [
                    'email' => 'required|string',
                    'password' => 'required|string'
                ]
            );

            $credentials = $request->only(['email', 'password']);

            if (!$token = Auth::attempt($credentials)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            return $this->respondWithToken($token);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], $th->getCode());
        }
    }

    public function me()
    {
        return response()->json([
            'status' => true,
            'message' => 'success',
            'data' => auth()->user()
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return response()->json([
            'status' => true,
            'message' => 'Logged out successfully'
        ]);
    }

    public function refresh()
    {
        try {
            if (!$token = auth()->refresh()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Token invalid'
                ], 401);
            }
            return response()->json([
                'status' => true,
                'message' => 'Token refreshed successfully',
                'token_access' => $token
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 401);
        }
    }

    protected function respondWithToken($token)
    {
        
        return response()->json([
            'status' => true,
            'token_type' => 'bearer',
            'access_token' => $token
        ]);
    }
}
