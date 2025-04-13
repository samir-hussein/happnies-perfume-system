<?php

namespace App\Http\Controllers\Expenses;

use App\Models\Safe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Partner\ExpensesFromCapital;
use App\Http\Controllers\Partner\PartnerController;
use App\Http\Controllers\Partner\StoreCapital;

class Store extends Controller
{
    public static function boot(Request $request)
    {
        $validated = $request->validate([
            "amount" => "required|numeric|min:1",
            "description" => "sometimes",
            "source" => "required|string|in:profits,capital",
            "purpose" => "required|string|in:miscellaneous,products"
        ]);

        $validated['amount'] = $validated['amount'] * -1;

        Safe::create($validated);

        if ($validated['source'] == "profits") {
            PartnerController::expensesFromProfits($validated['amount']);
        }

        if ($validated['source'] == "profits" && $validated['purpose'] == "products") {
            $request->request->add(["partner_id" => "all"]);
            StoreCapital::boot($request);
        }

        if ($validated['source'] == "capital" && $validated['purpose'] == "miscellaneous") {
            ExpensesFromCapital::boot($request->amount);
        }

        return back()->with("success", "تم صرف المبلغ بنجاح");
    }
}
