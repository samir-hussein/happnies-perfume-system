<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class Delete extends Controller
{
    public static function boot(Category $category)
    {
        $category->delete();

        return back()->with("success", "تم الحذف بنجاح");
    }
}
