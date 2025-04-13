<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class Store extends Controller
{
    public static function boot(array $request)
    {
        $order = Order::create($request);
        $products = $request['products'];
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
                    'created_at' => $order->created_at,
                    'updated_at' => $order->created_at,
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
