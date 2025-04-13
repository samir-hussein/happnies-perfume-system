<?php

namespace App\Http\Controllers\Product;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Show extends Controller
{
    public static function boot(Product $product)
    {
        return view("dashboard.product.show", [
            "categories" => Category::all(),
            "product" => $product->load("qty")
        ]);
    }
}
