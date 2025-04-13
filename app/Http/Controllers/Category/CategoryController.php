<?php

namespace App\Http\Controllers\Category;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        return Index::boot();
    }

    public function store(Request $request)
    {
        return Store::boot($request);
    }

    public function update(Request $request, Category $category)
    {
        return Update::boot($request, $category);
    }

    public function destroy(Category $category)
    {
        return Delete::boot($category);
    }
}
