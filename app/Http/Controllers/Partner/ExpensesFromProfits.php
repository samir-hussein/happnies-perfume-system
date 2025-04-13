<?php

namespace App\Http\Controllers\Partner;

use App\Models\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ExpensesFromProfits extends Controller
{
    public static function boot($amount)
    {
        $partners = Partner::all();

        foreach ($partners as $partner) {
            $partner->profits += ($amount * ($partner->ratio() / 100));
            $partner->save();
        }
    }
}
