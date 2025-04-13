<?php

namespace App\Http\Controllers\Wholesale;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WholesalePayRequest;

class WholesaleController extends Controller
{
    public function index()
    {
        return view('dashboard.Wholesale');
    }

    public function store(WholesalePayRequest $request)
    {
        return WholesalePay::boot($request->validated());
    }
}
