<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class Index extends Controller
{
    public static function boot()
    {
        return view("dashboard.partner.index", [
            "partners" => Partner::orderBy("capital", "desc")->get()
        ]);
    }
}
