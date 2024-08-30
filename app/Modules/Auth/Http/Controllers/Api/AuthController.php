<?php

namespace App\Modules\Auth\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Modules\Auth\Http\Requests\LoginRequest;
use App\Modules\Auth\Http\Requests\RegisterRequest;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->validated($request->only(['email', 'password']));

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                "status" => false,
                "data" => null,
                "message" => "Login Fail",
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        $token = $request->user()->createToken("LARAVEL_TOKEN");

        return response()->json([
            "status" => true,
            "data" => [
                'user' => $user,
                'token' => $token->plainTextToken,
            ],
            "message" => "Login successful",
        ], 200);
    }

    public function register(RegisterRequest $request)
    {
        $request->validated($request->only(['name', 'email', 'password']));

        $user = User::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            "status" => 200,
            "data" => [
                "user" => $user,
                "token" => $token,
            ],
            "message" => "Registration successful",
        ], 200);

    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
