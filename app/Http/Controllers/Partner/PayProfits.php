<?php

namespace App\Http\Controllers\Partner;

use App\Models\Safe;
use App\Models\Profit;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class PayProfits extends Controller
{
    public static function boot(Request $request)
    {
        $validated = $request->validate([
            'amount' => "required|numeric|min:1",
            'partner_id' => "sometimes",
            'payall' => "required|boolean"
        ]);

        $profits_history = [];

        if ($request->payall == 1) {
            $partners = Partner::all();
            $amount = 0;

            foreach ($partners as $partner) {
                $amount += $partner->profits;
                $partner_amount = $partner->profits;
                $partner->profits = 0;
                $partner->save();
                $profits_history[] = [
                    'partner_id' => $partner->id,
                    'amount' => $partner_amount,
                    'created_at' => new \DateTime()
                ];
            }
        } else {
            $amount = $validated['amount'];
            $partner = Partner::find($validated['partner_id']);
            if ($amount > $partner->profits) {
                return back()->with("error", "المبلغ المطلوب غير متوفر");
            }

            $partner->profits -= $amount;
            $partner->save();
            $profits_history[] = [
                'partner_id' => $partner->id,
                'amount' => $amount,
                'created_at' => new \DateTime()
            ];
        }

        Profit::insert($profits_history);

        Safe::create([
            "amount" => $amount * -1,
            "description" => "صرف ارباح",
            "source" => "profits"
        ]);

        return back()->with("success", "تم صرف الارباح بنجاح");
    }
}
