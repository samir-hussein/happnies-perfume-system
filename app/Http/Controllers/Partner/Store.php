<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class Store extends Controller
{
    public static function boot(Request $request)
    {
        $validate = $request->validate([
            "name" => "required|unique:partners,name",
            "capital" => "required|numeric|min:0"
        ]);

        Partner::create($validate);

        return back()->with("success", "تم الاضافة بنجاح");
    }
}
