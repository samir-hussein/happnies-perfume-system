<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class Warning extends Controller
{
    public static function boot()
    {
        $products = Product::with("qty")->get();

        $warningList = [];

        foreach ($products as $product) {
            $qty = $product->qty->sum("qty");
            if ($qty <= $product->warning_qty) {
                array_push($warningList, $product);
            }
        }

        return $warningList;
    }
}
