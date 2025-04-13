<?php

namespace App\Http\Controllers\Order;

use App\Models\Safe;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Partner\PartnerController;

class OnlinePay extends Controller
{
    public static function boot(Order $order)
    {
        if ($order->status == "finished") {
            return back()->with("error", "لا يمكن تعديل هذا المنتج");
        }

        $order = $order->load("items");
        Safe::create([
            "amount" => $order->total_price,
            "description" => "فاتورة بيع اون لاين بواسطة " . $order->employee,
        ]);

        if ($order->phone) {
            ClientController::store($order->client_name, $order->phone);
        }

        PartnerController::storeProfits($order->items, $order->total_price);

        $order->status = "finished";
        $order->save();

        return back()->with("success", "تم تسجيل الفاتورة بنجاح");
    }
}
