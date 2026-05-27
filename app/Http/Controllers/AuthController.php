<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request) {
        try {
            
            $credentials = $request->validate([
                "name" => "required|string|max:255",
                "password" => "required|string"
            ]);

            Log::debug('user logged', ['user' => $credentials]);

            $token = JWTAuth::attempt($credentials);

            if(!$token) {
                return response()->json([
                    'status_code' => 'error',
                    'message' => 'Invalid credentials'
                ], 401);
            }

            return response()->json([
                "status_code" => "success",
                "message" => "Login Successful",
                "data" => [
                    "user" => JWTAuth::user(),
                    "access_token" => $token,
                    "token_type" => "bearer"
                ]
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'status_code' => 'error',
                'message' => 'login failed',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ], 500);
        }
    }

    public function logout() {
        try {
            JWTAuth::parseToken()->authenticate();

            JWTAuth::invalidate(JWTAuth::getToken());

            return $this->handleResponse(null, "Logout successful.", 200);
        } catch (\Tymon\JWTAuth\Exceptions\TokenBlacklistedException $e) {
            return response()->json([
                'status_code' => 'failed',
                'message' => 'Token is invalid'
            ], 401);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'status_code' => 'error',
                'message' => 'Logout failed',
                'data' => [
                    'error' => $e->getMessage()
                ]
            ], 500);
        }
    }

    public function register(Request $request) {
        try {
            $data = $request->validate([
                "name" => "required|string|max:255",
                "email" => "required|email|unique:users,email",
                "password" => "required|string|min:8",
            ]);

            Log::debug('register data', [
                'data' => $data
            ]);

            $user = User::create([
                "name" => $data['name'],
                "email" => $data['email'],
                "password" => Hash::make($data['password']),
            ]);

            return $this->handleResponse($user, 'User registered successfull.', 201);
        } catch (\Throwable $e) {
            return $this->handleErrorResponse(null, "Something went wrong -" . $e->getMessage(), 500);
        }
    }
}
