<?php

namespace App\Modules\Auth\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auth\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

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
}
