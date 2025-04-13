<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class StoreProfits extends Controller
{
    public static function boot($data, $total_price)
    {
        $profits = 0;
        $total_price_products = 0;
        $partners = Partner::all();

        foreach ($data as $row) {
            $total_unit = $row['unit_price'] * $row['qty'];
            $total_price_products += $row['total_price'];

            $profits += ($row['total_price'] - $total_unit);
        }

        $profits -= ($total_price_products - $total_price);

        foreach ($partners as $partner) {
            $partner->profits += ($profits * ($partner->ratio() / 100));
            $partner->save();
        }
    }
}
