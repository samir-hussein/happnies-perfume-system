<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Store extends Controller
{
    public static function boot(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            "type" => "required|in:product,material"
        ]);

        Category::create($validated);

        return back()->with("success", "تم اضافة القسم بنجاح");
    }
}
