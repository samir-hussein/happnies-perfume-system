<?php

namespace App\Http\Controllers\Safe;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use App\Models\Safe;
use Illuminate\Http\Request;

class Index extends Controller
{
    public static function boot(Request $request)
    {
        $total = Safe::sum("amount");
        $profits = Partner::sum("profits");
        $capital = $total - $profits;

        $safe = Safe::query();

        if ($request->from) {
            $safe->whereDate("created_at", ">=", $request->from);
        }

        if ($request->to) {
            $safe->whereDate("created_at", "<=", $request->to);
        }

        $safe = $safe->latest()->get();

        return view("dashboard.safe.index", [
            "records" => $safe,
            "total" => $total,
            'profits' => $profits,
            'capital' => $capital
        ]);
    }
}
