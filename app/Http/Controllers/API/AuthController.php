<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $this->validate(request(), [
            'name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required'
        ]);

        return AuthService::register($request->email, $request->name, $request->password);

    }

    public function login(Request $request)
    {
        $this->validate(request(), [
            'email' => 'required',
            'password' => 'required'
        ]);

       return AuthService::login($request->email, $request->password);
    }

    public function logout(Request $request)
    {
        return AuthService::logout($request);
    }

    public function me(Request $request)
    {
        return AuthService::me();
    }
}
