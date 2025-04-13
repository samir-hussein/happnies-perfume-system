<?php

namespace App\Http\Controllers\Expenses;

use App\Models\Safe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Index extends Controller
{
    public static function boot(Request $request)
    {
        $total = Safe::query()->where("amount", "<", 0);

        $safe = Safe::query()->where("amount", "<", 0);

        $from = $request->from ?? date("Y-m-01");
        $to = $request->to ?? date("Y-m-t");

        $safe->whereDate("created_at", ">=", $from)->whereDate("created_at", "<=", $to);
        $total->whereDate("created_at", ">=", $from)->whereDate("created_at", "<=", $to);

        $safe = $safe->latest()->get();
        $total = $total->sum("amount") * -1;

        return view("dashboard.expenses.index", [
            "records" => $safe,
            "total" => $total
        ]);
    }
}
