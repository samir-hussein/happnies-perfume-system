<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductQty;

class OnlineCancel extends Controller
{
    public static function boot(Order $order, $update = false)
    {
        if ($order->status == "finished") {
            return back()->with("error", "لا يمكن تعديل هذا المنتج");
        }

        $order = $order->load("items");

        $items = $order->items;

        $codes = [];

        $items_by_code = [];
        $new_qty = [];

        foreach ($items as $item) {
            $codes[] = $item->code;
            $items_by_code[$item->code] = $item;
        }

        $products = Product::whereIn("code", $codes)->with("qty")->get();

        foreach ($products as $product) {
            $qty = $product->qty->sortBy("price");
            $order_item = $items_by_code[$product->code];

            foreach ($qty as $row) {
                if ($row->price == $order_item->unit_price) {
                    $row->qty += $order_item->qty;
                    $row->save();
                    $order_item->qty = 0;
                    break;
                }
            }

            if ($order_item->qty != 0) {
                $new_qty[] = [
                    "qty" => $order_item->qty,
                    "price" => $order_item->unit_price,
                    "product_id" => $product->id,
                    "created_at" => new \DateTime(),
                    "updated_at" => new \DateTime()
                ];
            }

            $product->save();
        }

        ProductQty::insert($new_qty);

        if ($update) {
            OrderItem::where("order_id", $order->id)->delete();
            return;
        };

        $order->delete();

        if (auth()->check()) {
            return redirect()->route("dashboard.order.online")->with("success", "تم الغاء الطلب بنجاح");
        } else {
            return redirect()->route("order.online")->with("success", "تم الغاء الطلب بنجاح");
        }
    }
}
