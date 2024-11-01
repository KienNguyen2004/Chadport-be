<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RegisterRequest;
use App\Http\Requests\Admin\LoginRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['logout', 'register', 'refresh']]);
    }

    public function register(RegisterRequest $request)
    {
        try {
            $userData = [
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'role_id' => $request->input('role_id'),
                'status' => 1
            ];

            $user = User::create($userData);

            return response()->json([
                'message' => 'Successfully created user',
                'user' => $user
            ], 201);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Could not register user',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid Credentials'], 401);
            }
            
            return response()->json([
                'message' => 'Successfully logged in',
                'token' => $token
            ], 200);

        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not create token',
                'message' => $e->getMessage()
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Login error',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();

            return response()->json([
                'message' => 'Successfully logged out',
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'error' => 'Could not log out',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function refresh()
    {
        try {
            $token = auth()->getToken();
    
            if (!$token) {
                return response()->json([
                    'error' => 'Token not provided',
                ], 400);
            }
    
            JWTAuth::setToken($token);
    
            // Refresh token
            $newToken = JWTAuth::refresh($token);
    
            return response()->json([
                'message' => 'Token refreshed successfully',
                'token' => $newToken
            ], 200);
    
        } catch (TokenExpiredException $e) {
            return response()->json([
                'error' => 'Token has expired',
                'message' => $e->getMessage()
            ], 401);
    
        } catch (TokenInvalidException $e) {
            return response()->json([
                'error' => 'Token is invalid',
                'message' => $e->getMessage()
            ], 401);
    
        } catch (JWTException $e) {
            return response()->json([
                'error' => 'Could not refresh token',
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
}
