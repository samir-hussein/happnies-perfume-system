<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OnlineShow extends Controller
{
    public static function boot(Order $order)
    {
        $data = $order->load(["items", "gather", "invoice"]);

        $gather = [];

        foreach ($data->gather as $item) {
            $gather[$item["gather_id"]][] = $item;
        }

        return view("online-show", [
            "order" => $data,
            "employees" => Employee::latest()->get(),
            "gather" => $gather
        ]);
    }
}
