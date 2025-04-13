<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Order;
use Illuminate\Http\Request;

class Show extends Controller
{
    public static function boot(Order $order)
    {
        $data = $order->load(["items", "gather", "invoice"]);

        $gather = [];

        foreach ($data->gather as $item) {
            $gather[$item["gather_id"]][] = $item;
        }

        return view("dashboard.order.show", [
            "order" => $data,
            "employees" => Employee::latest()->get(),
            "gather" => $gather
        ]);
    }
}
