<?php

namespace App\Http\Controllers\Pay;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\GatherItmes\GatherItemsController;
use App\Models\GatherItem;
use App\Models\Invoice;

class Update extends Controller
{
    public static function boot(array $request, Order $order)
    {
        if ($order->status == "finished") {
            return response()->json([
                "status" => "error",
                "errors" => ["لا يمكن تعديل هذا المنتج"]
            ], 422);
        }

        // check products
        $response = CheckProducts::boot($request['data_invoice']);

        if ($response['status'] == "error") {
            return response()->json($response, 422);
        }

        $request['products'] = $response['products'];
        $request['price'] = $response['total'];
        if ($request['discount_type'] == "amount") {
            $request['total_price'] = $response['total'] - $request['discount'];
        } else {
            $request['total_price'] = $response['total'] - ($response['total'] * $request['discount'] / 100);
        }

        $response = OrderController::update($request, $order);
        $order = $response['order'];

        Invoice::where("order_id", $order->id)->delete();

        InvoiceController::store($request['invoice_items'], $order->id);

        GatherItem::where("order_id", $order->id)->delete();

        if (isset($request["gather_items"])) {
            GatherItemsController::store($request['gather_items'], $order->id);
        }

        return response()->json([
            "items" => $request['invoice_items'],
            "data" => $order
        ]);
    }
}
