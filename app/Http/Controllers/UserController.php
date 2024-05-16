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
        $this->validate($request, [
            'email' => 'email|string|required',
            'password' => 'string|required'
        ]);

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
            ], 404);
        }
    }

    // Logout function (already provided)
    public function logout(Request $request){
        try {
            $tokenValue = $request->input('tokenValue');
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

    // Create function for creating a new user
    public function register(Request $request) {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
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
        return response()->json(['message' => 'User registered successfully'], 201); 
    } 
}