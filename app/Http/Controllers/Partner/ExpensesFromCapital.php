<?php

namespace App\Http\Controllers\Partner;

use App\Models\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpensesFromCapital extends Controller
{
    public static function boot($amount)
    {
        $partners = Partner::all();
        $capital = Partner::sum("capital");

        foreach ($partners as $partner) {
            $partner->capital -= ($amount * ($partner->ratio($capital) / 100));
            $partner->save();
        }
    }
}
