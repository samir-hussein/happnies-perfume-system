<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class Destroy extends Controller
{
    public static function boot(Partner $partner)
    {
        $partner->delete();

        return back()->with("success", "تم الحذف بنجاح");
    }
}
