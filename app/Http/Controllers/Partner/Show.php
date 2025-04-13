<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class Show extends Controller
{
    public static function boot(Partner $partner)
    {
        return view("dashboard.partner.show", [
            "partner" => $partner->load("profitsHistory")
        ]);
    }
}
