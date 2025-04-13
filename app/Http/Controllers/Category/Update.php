<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Update extends Controller
{
    public static function boot(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string|max:255|unique:categories,name,' . $category->id,
            "type" => "sometimes|in:product,material"
        ]);

        $category->update($validated);

        return back()->with("success", "تم تحديث البيانات بنجاح");
    }
}
