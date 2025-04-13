<?php

namespace App\Http\Controllers\GatherItmes;

use App\Http\Controllers\Controller;
use App\Models\GatherItem;
use Illuminate\Http\Request;

class Store extends Controller
{
    public static function boot(array $data, int $order_id)
    {
        $insert = [];

        foreach ($data as $key => $value) {
            foreach ($value as $k => $v) {
                $insert[] = [
                    'gather_id' => $key,
                    "order_id" => $order_id,
                    'code' => $k,
                    "name" => $v['name'],
                    "price" => $v['price'],
                    "qty" => $v['qty'],
                    "created_at" => new \DateTime
                ];
            }
        }

        GatherItem::insert($insert);
    }
}
