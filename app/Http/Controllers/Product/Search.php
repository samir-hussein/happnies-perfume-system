<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class Search extends Controller
{
    public static function boot(Request $request)
    {
        $products = Product::where("code", "like", "%" . $request->search . "%")->orWhere("name", "like", "%" . $request->search . "%")->with(["qty", "category"])->latest()->get();

        foreach ($products as $product) {
            $product->priceAfter = $product->priceAfterDiscount();
            $product->total_qty = $product->qty->sum("qty");
            $product->type = $product->category->type;
            if ($product->discount_type == "ratio") {
                $product->discount = $product->discount . " %";
            } else {
                $product->discount = $product->discount . " جنية";
            }
        }

        return response()->json([
            'data' => $products
        ]);
    }
}
