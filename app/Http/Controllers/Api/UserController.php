<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Requests\Api\UpdateUserRequest;
use App\Mail\RegisterUserMail;
use App\Models\User;
use App\Traits\ImageUploadTrait;
use Exception;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class UserController extends Controller
{

    use ImageUploadTrait;

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

            $activationLink = route('activate-account', ['user_id' => $user->user_id, 'token' => $activationToken]);  // send main\l --> PT SMTP laravel | hhtps

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


    public function update(UpdateUserRequest $request)  
    {
        try {
            if (auth()->user()->user_id == $request->id) {
                $user = User::findOrFail($request->id);
    
                $user->fill($request->only([
                    'first_name',
                    'last_name',
                    'gender',
                    'birthday',
                    'address',
                    'phone_number'
                ]));
    
                if ($request->hasFile('image_user')) {
                    $data = $this->handleUploadImage($request, 'image_user', 'avt_image');
                    if ($data) {
                        $user->image_user = $data;
                    } 
                }
    
                $user->save();
    
                return response()->json(['message' => 'User information updated successfully', 'user' => $user], 200);
            } else {
                return response()->json(['error' => 'Unauthorized action'], 403);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Could not update user information',
                'message' => $e->getMessage()
            ], 500);
        }
    }
 
}
