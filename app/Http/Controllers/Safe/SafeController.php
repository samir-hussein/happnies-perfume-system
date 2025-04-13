<?php

namespace App\Http\Controllers\Safe;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SafeController extends Controller
{
    public function index(Request $request)
    {
        return Index::boot($request);
    }

    public function store(Request $request)
    {
        return Store::boot($request);
    }
}
