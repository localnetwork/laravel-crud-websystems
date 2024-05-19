<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function login(Request $request){ 

        if (!$request->isMethod('post')) {
            return response()->json([
            'message' => 'Invalid request method. Only POST method is allowed.',
            ], 405);
        } 

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } 

        $credentials = $request->only([
            'email', 'password' 
        ]); 

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json([
            'token' => $token,
            'user' => $user,
            ], 200);
        } else {
            return response()->json([
            "errors" => [
                'message' => 'These credentials do not match our records.',
            ]
            ], 422);
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        } 

        $credentials = $request->only([
            'email', 'password' 
        ]); 

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('api-token')->plainTextToken;
            return response()->json([
                'token' => $token,
                'user' => $user,
            ], 200);
        } else {
            return response()->json([
                'message' => 'User does not exist',
            ], 422);
        }
    }

    public function logout(Request $request){
        try {
            $tokenValue = $request->bearerToken();
            $accessToken = PersonalAccessToken::findToken($tokenValue);
    
            if ($accessToken) {
                $accessToken->delete();
                return response()->json([
                    'message' => 'Logout successfully!',
                ]);
            } else {
                return response()->json([
                    'message' => 'Cannot find token',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        } 
    }

    public function register(Request $request) {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'max:255',
                'unique:users',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'
            ],
            'avatar' => 'required',
            'avatar_color' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // If validation fails, return JSON response with validation errors
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create a new user
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        // Return JSON response indicating successful registration
    return response()->json(['message' => 'Account created successfully.'], 200); 
    } 
}