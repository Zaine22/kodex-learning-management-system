<?php

namespace App\Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auth\Http\Requests\LoginRequest;
use App\Modules\Auth\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $request->validated($request->only(['email', 'password']));

        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Login Fail",
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        $token = $request->user()->createToken("LARAVEL_TOKEN");

        return response()->json([
            "status"  => true,
            "data"    => [
                'user'  => $user,
                'token' => $token->plainTextToken,
            ],
            "message" => "Login successful",
        ], 200);
    }

    //change password
    public function changePassword(Request $request)
    {
        // Validate the input
        $request->validate([
            'current_password'      => 'required',
            'new_password'          => 'required|min:8',
            'password_confirmation' => 'required|min:6|same:new_password',
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Check if the current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                "status"  => false,
                "data"    => null,
                "message" => "Current password is incorrect.",
            ], 500);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            "status"  => true,
            "message" => "Password Changed Successfully.",
        ], 200);
    }

    public function register(RegisterRequest $request)
    {
        $request->validated($request->only(['name', 'email', 'password']));

        $user = User::create([
            'name'     => $request->name,
            'slug'     => Str::slug($request->name),
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('API Token')->plainTextToken;

        return response()->json([
            "status"  => 200,
            "data"    => [
                "user"  => $user,
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
