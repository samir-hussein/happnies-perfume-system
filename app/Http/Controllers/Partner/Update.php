<?php

namespace App\Http\Controllers\Partner;

use App\Models\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Update extends Controller
{
    public static function boot(Request $request, Partner $partner)
    {
        $validate = $request->validate([
            "name" => "sometimes|unique:partners,name," . $partner->id,
            "capital" => "sometimes|numeric|min:0"
        ]);

        $partner->update($validate);

        return back()->with("success", "تم التحديث بنجاح");
    }
}
