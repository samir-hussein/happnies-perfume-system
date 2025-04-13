<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class Destroy extends Controller
{
    public static function boot(Product $product)
    {
        $product->delete();

        return back()->with("success", "تم الحذف بنجاح");
    }
}
