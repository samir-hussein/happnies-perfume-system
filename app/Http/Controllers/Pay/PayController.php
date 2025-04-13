<?php

namespace App\Http\Controllers\Pay;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\PayRequest;
use App\Http\Controllers\Controller;

class PayController extends Controller
{
    public function store(PayRequest $request)
    {
        return Store::boot($request->validated());
    }

    public function update(PayRequest $request, Order $order)
    {
        return Update::boot($request->validated(), $order);
    }
}
