<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Update extends Controller
{
    public static function boot(array $request, Order $order)
    {
        $order->update($request);
        OnlineCancel::boot($order, true);

        $ids = array_keys($request['data_invoice']);
        $products = Product::whereIn("code", $ids)->with("qty")->get();

        $order_items = [];

        foreach ($products as $product) {
            $qtys = $product->qty->sortBy("price");

            foreach ($qtys as $qty) {
                $required_qty = $request['data_invoice'][$product->code];
                $price = $product->price;

                $diff = $qty->qty - $required_qty;

                if ($diff < 0) {
                    $required_qty = $required_qty - ($diff * -1);
                    $request['data_invoice'][$product->code] = $diff * -1;
                }

                $order_items[] = [
                    'order_id' => $order->id,
                    'name' => $product->name,
                    'code' => $product->code,
                    'qty' => $required_qty,
                    'unit_price' => $qty->price,
                    'price' => $price,
                    'discount' => $product->discount,
                    'discount_type' => $product->discount_type,
                    'total_price' => $required_qty * $product->priceAfterDiscount(),
                    'created_at' => new \DateTime
                ];

                if ($diff > 0) {
                    $qty->qty -= $required_qty;
                    $qty->save();
                    break;
                }

                if ($diff == 0) {
                    $qty->delete();
                    break;
                }

                if ($diff < 0) {
                    $qty->delete();
                }
            }
        }

        OrderItem::insert($order_items);

        return [
            "order" => $order,
            "order_items" => $order_items
        ];
    }
}
