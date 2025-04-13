<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class Store extends Controller
{
    public static function boot(array $products)
    {
        $notifications = [];

        $list = Notification::pluck("product_id");

        foreach ($products as $product) {
            if (!$list->contains($product->id)) {
                $notifications[] = [
                    'text' => "الكمية المتبقية من " . $product->name . " هى " . $product->qty->sum("qty") . " " . $product->unit . " كود المنتج : " . $product->code,
                    'product_id' => $product->id,
                    'created_at' => new \DateTime(),
                ];
            }
        }

        Notification::insert($notifications);
    }
}
