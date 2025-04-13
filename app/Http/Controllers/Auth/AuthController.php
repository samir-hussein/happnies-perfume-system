<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{
    public function store(RegisterRequest $request)
    {
        return Register::boot($request->validated());
    }

    public function login(LoginRequest $request)
    {
        return Login::boot($request->validated());
    }

    public function logout()
    {
        return Logout::boot();
    }
}
