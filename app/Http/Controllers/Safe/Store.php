<?php

namespace App\Http\Controllers\Safe;

use App\Http\Controllers\Controller;
use App\Models\Safe;
use Illuminate\Http\Request;

class Store extends Controller
{
    public static function boot(Request $request)
    {
        $validated = $request->validate([
            "amount" => "required|numeric|min:1",
            "description" => "sometimes",
        ]);

        Safe::create($validated);

        return back()->with("success", "تم ايداع المبلغ بنجاح");
    }
}
