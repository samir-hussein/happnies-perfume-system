<?php

namespace App\Http\Controllers\Pay;

use App\Http\Controllers\Client\ClientController;
use App\Models\Safe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GatherItmes\GatherItemsController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Partner\PartnerController;

class Store extends Controller
{
    public static function boot(array $request)
    {
        // check products
        $response = CheckProducts::boot($request['data_invoice']);

        if ($response['status'] == "error") {
            return response()->json($response, 422);
        }

        $request['products'] = $response['products'];
        $request['price'] = $response['total'];
        $request['updated_at'] = $request['created_at'] ?? now();
        if ($request['discount_type'] == "amount") {
            $request['total_price'] = $response['total'] - $request['discount'];
        } else {
            $request['total_price'] = $response['total'] - ($response['total'] * $request['discount'] / 100);
        }

        $response = OrderController::store($request);
        $order = $response['order'];
        $order_items = $response['order_items'];

        if ($request['type'] == "offline") {
            Safe::create([
                "amount" => $order->total_price,
                "description" => "فاتورة بيع بواسطة " . $request['employee'],
            ]);

            if ($request['phone']) {
                ClientController::store($request['client_name'], $request['phone']);
            }

            PartnerController::storeProfits($order_items, $request['total_price']);
        }

        InvoiceController::store($request['invoice_items'], $order->id);

        if (isset($request["gather_items"])) {
            GatherItemsController::store($request['gather_items'], $order->id);
        }

        return response()->json([
            "items" => $request['invoice_items'],
            "data" => $order
        ]);
    }
}
