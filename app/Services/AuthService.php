<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    public static function register($email, $name, $password)
    {
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        return self::login($email, $password);
    }

    public static function login($email, $password)
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = \auth()->user();

            $user->tokens()->delete();

            $token = $user->createToken("API TOKEN")->plainTextToken;

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $token
            ], 200);

        } else {
            return response()->json([
                'message' => 'Invalid login details',
            ], 401);
        }

    }

    public static function logout($request)
    {
        $request->user()->currentAccessToken()->delete();
    }

    public static function me()
    {
        return new UserResource(\auth()->user());
    }
}
