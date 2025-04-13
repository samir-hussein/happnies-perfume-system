<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductQty;
use Illuminate\Http\Request;

class Store extends Controller
{
    public static function boot(array $request)
    {
        $request['discount'] = $request['discount'] ?? 0;

        $product = Product::where("code", $request['code'])->with("qty")->first();

        if ($product) {
            $request['category_id'] = $product->category_id;
            $request['qty'] = $product->qty->sum("qty") + $request['qty'];
            $request['name'] = $request['name'] ?? $product->name;
            $request['unit'] = $request['unit'] ?? $product->unit;
            $request['description'] = $request['description'] ?? $product->description;
            $request['warning_qty'] = $request['warning_qty'] ?? $product->warning_qty;
            $request['discount'] = $request['discount'] ?? $product->discount;
            $request['discount_type'] = $request['discount_type'] ?? $product->discount_type;
            Update::boot($request, $product);
            return back()->with("success", "تم تحديث البيانات بنجاح");
        }

        if (!$request['name']) {
            return back()->with("error", "يجب ادخال اسم المنتج");
        }

        $product = Product::create($request);

        ProductQty::create([
            "qty" => $request["qty"],
            "product_id" => $product->id,
            "price" => $request["unit_price"],
            "store_date" => new \DateTime
        ]);

        return back()->with("success", "تم الاضافة بنجاح");
    }
}
