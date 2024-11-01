<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Mail\RegisterUserMail;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;


class UserController extends Controller
{
    public function __construct(Request $request)
    {
        $this->middleware('auth:api')->only(['logout', 'refresh']);
    }


    public function register(RegisterRequest $request)
    {
        try {
            $activationToken = Str::random(10);

            $userData = [
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone_nuber' => $request->input('phone_nuber'),
                'role_id' => 4,
                'status' => 0
            ];

            $user = User::create($userData);

            $activationLink = route('activate-account', ['user_id' => $user->user_id, 'token' => $activationToken]);

            Cache::put('activation_token_' . $user->id, $activationToken, now()->addDay());

            Mail::to($user->email)->send(new RegisterUserMail($user, $activationLink));

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
            $user = User::where('email', $credentials['email'])->first();
            if (!$user || $user->status != 1) {
                return response()->json(['error' => 'Account is not verified.'], 403);
            }
    
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

    public function activateAccount($user_id, $token)
    {
        $cachedToken = Cache::get('activation_token_' . $user_id);
    
        if (!$cachedToken || $cachedToken !== $token) {
            return response()->json(['error' => 'Invalid or expired activation link'], 403);
        }
    
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
    
        $user->status = 1;
        $user->save();
    
        Cache::forget('activation_token_' . $user_id);
    
        return response()->json(['message' => 'Account activated successfully!'], 200);
    }
    
    
    
}
