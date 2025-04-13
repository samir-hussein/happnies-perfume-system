<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Logout extends Controller
{
    public static function boot($flashMsg = null)
    {
        Auth::guard()->logout();

        Request()->session()->invalidate();

        Request()->session()->regenerateToken();

        if ($flashMsg) {
            Session::flash('success', $flashMsg);
        }

        return redirect()->route('home');
    }
}
