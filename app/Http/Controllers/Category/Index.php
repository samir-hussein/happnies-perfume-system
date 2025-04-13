<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class Index extends Controller
{
    public static function boot()
    {
        return view("dashboard.category.index", [
            "categories" => Category::with("products")->latest()->get()
        ]);
    }
}
