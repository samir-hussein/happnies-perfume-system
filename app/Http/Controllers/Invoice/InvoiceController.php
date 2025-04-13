<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public static function store(array $items, int $order_id)
    {
        return Store::boot($items, $order_id);
    }
}
