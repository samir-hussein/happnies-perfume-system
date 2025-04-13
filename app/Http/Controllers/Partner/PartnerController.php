<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Index::boot();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return Store::boot($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Partner $partner)
    {
        return Show::boot($partner);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partner $partner)
    {
        return Update::boot($request, $partner);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partner $partner)
    {
        return Destroy::boot($partner);
    }

    public static function storeProfits($data, $total_price)
    {
        return StoreProfits::boot($data, $total_price);
    }

    public static function expensesFromProfits($data)
    {
        return ExpensesFromProfits::boot($data);
    }

    public function payProfits(Request $request)
    {
        return PayProfits::boot($request);
    }

    public function storeCapital(Request $request)
    {
        return StoreCapital::boot($request, true);
    }
}
