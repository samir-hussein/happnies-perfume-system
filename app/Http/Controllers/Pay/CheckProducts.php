<?php

namespace App\Http\Controllers\Pay;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class CheckProducts extends Controller
{
    public static function boot(array $products_qty)
    {
        $ids = array_keys($products_qty);
        $products = Product::whereIn("code", $ids)->with("qty")->get();

        if (count($products) != count($ids)) {
            return [
                "status" => "error",
                "message" => "منتجات غير موجودة بالنظام."
            ];
        }

        $errors = [];
        $total = 0;

        foreach ($products as $product) {
            $total += $product->priceAfterDiscount() * $products_qty[$product->code];
            if ($product->qty->sum("qty") < $products_qty[$product->code]) {
                array_push($errors, "الكمية المتوفرة من " . $product->name . " غير كافية");
            }
        }

        if (count($errors) > 0) {
            return [
                "status" => "error",
                "errors" => $errors
            ];
        }

        return [
            "status" => "success",
            "products" => $products,
            "total" => $total
        ];
    }
}
