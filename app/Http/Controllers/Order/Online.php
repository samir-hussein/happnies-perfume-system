<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class Online extends Controller
{
    public static function boot(Request $request)
    {
        $total = Order::query()->where("status", "pendding");

        $orders = Order::query()->where("status", "pendding");

        if ($request->from) {
            $orders->whereDate("created_at", ">=", $request->from);
            $total->whereDate("created_at", ">=", $request->from);
        }

        if ($request->to) {
            $orders->whereDate("created_at", "<=", $request->to);
            $total->whereDate("created_at", "<=", $request->to);
        }

        if (!$request->from && !$request->to) {
            $total->whereDate("created_at", ">=", date("Y-m"));
            $orders->whereDate("created_at", ">=", date("Y-m"));
        }

        $orders = $orders->latest()->get();
        $total = $total->sum("total_price");

        return view("dashboard.order.online", [
            "orders" => $orders,
            "total" => $total,
        ]);
    }
}
