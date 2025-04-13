<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class Create extends Controller
{
    public static function boot()
    {
        return view("dashboard.product.store", [
            "categories" => Category::all()
        ]);
    }
}
