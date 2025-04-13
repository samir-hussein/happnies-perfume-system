<?php

namespace App\Http\Controllers\Partner;

use App\Models\Safe;
use App\Models\Partner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StoreCapital extends Controller
{
    public static function boot(Request $request, $store_safe = false)
    {
        $validated = $request->validate([
            'amount' => "required|numeric|min:1",
            'partner_id' => "required",
        ]);

        if ($validated['partner_id'] == "all") {
            $partners = Partner::all();
            $capital = Partner::sum("capital");

            foreach ($partners as $partner) {
                $partner->capital += ($validated['amount'] * ($partner->ratio($capital) / 100));
                $partner->save();
            }
        } else {
            $partner = Partner::find($validated['partner_id']);
            if (!$partner) {
                return back()->with("error", "لم يتم العثور على الشريك");
            }

            $partner->capital += $validated['amount'];
            $partner->save();
        }

        if ($store_safe) {
            Safe::create([
                "amount" => $validated['amount'],
                "description" => "اضافة رأس مال",
            ]);

            return back()->with("success", "تم اضافة رأس المال بنجاح");
        }

        return;
    }
}
