<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthService extends AbstractService
{
    /**
     * @param $email
     * @param $name
     * @param $password
     * @return JsonResponse
     */
    public static function register($email, $name, $password): JsonResponse
    {
        User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password)
        ]);

        return self::apiResponse('User created successfully');
    }

    /**
     * @param $email
     * @param $password
     * @return JsonResponse
     */
    public static function login($email, $password): JsonResponse
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

    /**
     * @param $request
     * @return void
     */
    public static function logout($request): void
    {
        $request->user()->currentAccessToken()->delete();
    }

    /**
     * Shows auth user
     *
     * @return UserResource
     */
    public static function me(): UserResource
    {
        return new UserResource(\auth()->user());
    }
}
