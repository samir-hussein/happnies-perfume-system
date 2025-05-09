<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Product;
use Illuminate\Http\Request;

class Update extends Controller
{
    public static function boot(array $request, Product $product)
    {
        $product->update($request);

        if ($request['unit_price'] && $request['qty'] != 0) {
            $match_qty = $product->qty->where("price", $request['unit_price'])->first();

            if ($match_qty) {
                $match_qty->qty += $request['qty'];
                $match_qty->store_date = new \DateTime;
                $match_qty->save();
            } else {
                $product->qty()->create([
                    "qty" => $request['qty'],
                    "price" => $request['unit_price'],
                    "store_date" => new \DateTime
                ]);
            }
        }

        $check_notification_list = Notification::where("product_id", $product->id)->first();

        if ($check_notification_list && $request["qty"] > $product->warning_qty) {
            Notification::where("product_id", $product->id)->delete();
        }

        return back()->with("success", "تم تحديث البيانات بنجاح");
    }
}
