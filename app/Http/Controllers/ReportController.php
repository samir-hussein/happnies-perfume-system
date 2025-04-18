<?php

namespace App\Http\Controllers;

use App\Exports\ReportExport;
use App\Models\Safe;
use App\Models\Order;
use App\Models\Partner;
use App\Models\Profit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->year;
        $months = range(1, 12);
        $data = [];

        foreach ($months as $month) {
            if ($month < 10) $month = '0' . $month;

            if (($year . "-" . $month) <= date("Y-m")) {
                $data[$year . "-" . $month] = [
                    "month" => $year . "-" . $month,
                ];
            }
        }

        $analysis = Order::query()
            ->where("status", "finished")
            ->select(
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m') as month"),
                DB::raw("COUNT(DISTINCT orders.id) as orders"),
                DB::raw("SUM(orders.total_price) as total_price")
            )
            ->groupBy(DB::raw("DATE_FORMAT(orders.updated_at, '%m')"))
            ->where(DB::raw("DATE_FORMAT(orders.updated_at, '%Y')"), $year)
            ->get();

        $unit_price = Order::query()
            ->leftJoin("order_items as o", "orders.id", "o.order_id")
            ->where("status", "finished")
            ->select(
                DB::raw("SUM(o.qty * o.unit_price) as total_unit_price"),
                DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m') as month")
            )
            ->groupBy(DB::raw("DATE_FORMAT(orders.updated_at, '%m')"))
            ->where(DB::raw("DATE_FORMAT(orders.updated_at, '%Y')"), $year)
            ->get();

        foreach ($analysis as $item) {
            $data[$item->month] = $item->toArray();
        }

        foreach ($unit_price as $item) {
            $data[$item->month]['profits'] = $data[$item->month]['total_price'] - $item->total_unit_price;
            $data[$item->month]['total_unit_price'] = $item->total_unit_price;
        }

        $expenses = Safe::where(DB::raw("DATE_FORMAT(created_at, '%Y')"), $year)
            ->where("purpose", "miscellaneous")
            ->where("amount", "<", 0)
            ->select(
                DB::raw("SUM(amount * -1) as expenses"),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
            )
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m')"))
            ->get();

        foreach ($expenses as $item) {
            $data[$item->month]['expenses'] = $item->expenses;
            $data[$item->month]['profits'] -= $item->expenses;
        }

        $products_expenses = Safe::where(DB::raw("DATE_FORMAT(created_at, '%Y')"), $year)
            ->where("purpose", "products")
            ->where("amount", "<", 0)
            ->select(
                DB::raw("SUM(amount * -1) as expenses"),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
            )
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m')"))
            ->get();

        foreach ($products_expenses as $item) {
            $data[$item->month]['products_expenses'] = $item->expenses;
        }

        $paid_profits = Profit::where(DB::raw("DATE_FORMAT(created_at, '%Y')"), $year)
            ->select(
                DB::raw("SUM(amount) as paid_profits"),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
            )
            ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m')"))
            ->get();

        foreach ($paid_profits as $item) {
            $data[$item->month]['paid_profits'] = $item->paid_profits;
        }

        $safe = Safe::where(DB::raw("DATE_FORMAT(created_at, '%Y')"), $year)
            ->select("amount", DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"))
            ->get();

        foreach ($data as &$item) {
            if ($item['month'] > date("Y-m")) continue;
            $item['safe'] = $safe->where("month", "<=", $item['month'])->sum("amount");
        }

        return Excel::download(new ReportExport($data), 'monthly-report-' . date("Y-m-d") . '.xlsx');
    }
}
