<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return Index::boot($request);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Create::boot();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        return Store::boot($request->validated());
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return Show::boot($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Product $product)
    {
        return Update::boot($request->validated(), $product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        return Destroy::boot($product);
    }

    public function search(Request $request)
    {
        return Search::boot($request);
    }
}
