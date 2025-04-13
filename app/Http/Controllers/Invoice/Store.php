<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class Store extends Controller
{
    public static function boot(array $items, int $order_id)
    {
        foreach ($items as &$item) {
            $item['order_id'] = $order_id;
        }

        Invoice::insert($items);
    }
}
