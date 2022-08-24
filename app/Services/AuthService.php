<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthService extends AbstractService
{
    public static function register($email, $name, $password)
    {
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        return self::apiResponse('User created successfully');
    }

    public static function login($email, $password)
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = \auth()->user();
            $user->tokens()->delete();
            $token = $user->createToken("API TOKEN")->plainTextToken;

            return self::apiResponse('User Logged In Successfully', ['token' => $token]);

        } else {

            return self::apiResponse('Invalid login details', [], 401);
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
