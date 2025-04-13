<?php

namespace App\Http\Controllers\Wholesale;

use App\Models\Safe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Pay\CheckProducts;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Client\ClientController;
use App\Http\Controllers\Invoice\InvoiceController;
use App\Http\Controllers\Partner\PartnerController;

class WholesalePay extends Controller
{
    public static function boot(array $request)
    {
        // check products
        $response = CheckProducts::boot($request['data_invoice']);

        if ($response['status'] == "error") {
            return response()->json($response, 422);
        }

        $request['products'] = $response['products'];
        $total = 0;

        foreach ($request['invoice_items'] as $product) {
            $total += $product['qty'] * $product['price'];
        }

        $request['total_price'] = $total;
        $request['price'] = $total;

        $response = OrderController::storeWholesale($request);
        $order = $response['order'];
        $order_items = $response['order_items'];

        Safe::create([
            "amount" => $order->total_price,
            "description" => "فاتورة بيع جملة",
        ]);

        if ($request['phone']) {
            ClientController::store($request['client_name'] . " (جملة)", $request['phone']);
        }

        PartnerController::storeProfits($order_items, $request['total_price']);

        InvoiceController::store($request['invoice_items'], $order->id);

        return response()->json([
            "items" => $request['invoice_items'],
            "data" => $order
        ]);
    }
}
