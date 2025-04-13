<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OnlineOrderList extends Controller
{
    public static function boot()
    {
        $orders = Order::query()->where("status", "pendding");

        $orders = $orders->latest()->get();

        return view("order", [
            "orders" => $orders,
        ]);
    }
}
