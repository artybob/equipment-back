<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    private AuthService $service;

    public function __construct()
    {
        $this->service = new AuthService;
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        return $this->service->register($request->email, $request->name, $request->password);
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        return $this->service->login($request->email, $request->password);
    }

    /**
     * @param Request $request
     * @return void
     */
    public function logout(Request $request): void
    {
        $this->service->logout($request);
    }

    /**
     * @param Request $request
     * @return UserResource
     */
    public function me(Request $request): UserResource
    {
        return $this->service->me();
    }
}
