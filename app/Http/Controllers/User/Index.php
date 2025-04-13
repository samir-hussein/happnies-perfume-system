<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Index extends Controller
{
    public static function boot()
    {
        return view("dashboard.user.index", [
            "users" => User::latest()->get()
        ]);
    }
}
