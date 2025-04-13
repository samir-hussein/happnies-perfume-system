<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        return Index::boot($request);
    }

    public function online(Request $request)
    {
        return Online::boot($request);
    }

    public static function store(array $request)
    {
        return Store::boot($request);
    }

    public static function storeWholesale(array $request)
    {
        return StoreWholesale::boot($request);
    }

    public static function update(array $request, Order $order)
    {
        return Update::boot($request, $order);
    }

    public function show(Order $order)
    {
        return Show::boot($order);
    }

    public function onlinePay(Order $order)
    {
        return OnlinePay::boot($order);
    }

    public function onlineCancel(Order $order)
    {
        return OnlineCancel::boot($order);
    }

    public function onlineOrdersList()
    {
        return OnlineOrderList::boot();
    }

    public function onlineShow(Order $order)
    {
        return OnlineShow::boot($order);
    }
}
