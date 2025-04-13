<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public static function boot(array $credentials)
    {
        if (Auth::guard()->attempt($credentials)) {
            Request()->session()->regenerate();
            return redirect()->intended('/dashboard/home');
        }

        return back()->withError('كلمة المرور المقدمة غير صحيحة.');
    }
}
