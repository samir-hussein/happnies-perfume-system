<?php

namespace App\Http\Controllers\Product;

use App\Exports\ProductsExport;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class Index extends Controller
{
    public static function boot(Request $request)
    {
        $from = $request->from ?? Date("Y-m-01");
        $to = $request->to ?? Date("Y-m-t");

        $query = Product::query()->leftJoin("order_items as o", "products.code", "o.code")->with("category", "qty")->groupBy("products.id");

        if ($request->categories && count($request->categories) > 0) {
            $query->whereIn("category_id", $request->categories);
        }

        $query->select("products.*", DB::raw("COALESCE(SUM(CASE WHEN DATE(o.created_at) BETWEEN '" . $from . "' AND '" . $to . "' THEN o.qty ELSE 0 END),0) as qty_sold", [$from, $to]), DB::raw("COALESCE(COUNT(DISTINCT CASE WHEN DATE(o.created_at) BETWEEN '" . $from . "' AND '" . $to . "' THEN o.order_id ELSE NULL END),0) as times_sold", [$from, $to]));

        $products = $query->latest()->get();

        $total_cost = 0;
        $profits = 0;
        $oil = 0;
        $oil_sold = 0;

        foreach ($products as $product) {
            $total_cost += $product->totalCost();
            $profits += $product->profit();
            if ($product->unit == "جرام") {
                $oil += $product->qty->sum("qty");
                $oil_sold += $product->qty_sold;
            }
        }

        if ($request->excel) {
            return Excel::download(new ProductsExport($products, $from, $to), 'products-report-' . date("Y-m-d") . '.xlsx');
        }

        return view("dashboard.product.index", [
            "products" => $products,
            "total_cost" => $total_cost,
            "profits" => $profits,
            "categories" => Category::latest()->get(),
            "oil" => $oil,
            "oil_sold" => $oil_sold
        ]);
    }
}
