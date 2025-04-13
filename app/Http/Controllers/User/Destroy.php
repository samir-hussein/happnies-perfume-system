<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class Destroy extends Controller
{
    public static function boot(User $user)
    {
        $user->delete();

        return back()->with("success", "تم الحذف بنجاح");
    }
}
