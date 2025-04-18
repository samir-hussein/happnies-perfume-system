<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class Index extends Controller
{
	public static function boot(Request $request)
	{
		$total = Order::query()->where("status", "finished");

		$orders = Order::query()->where("status", "finished");


		$from = $request->from ?? date("Y-m-01");
		$to = $request->to ?? date("Y-m-t");

		$orders->whereDate("updated_at", ">=", $from)->whereDate("updated_at", "<=", $to);
		$total->whereDate("updated_at", ">=", $from)->whereDate("updated_at", "<=", $to);

		$orders = $orders->latest("updated_at")->get();
		$total = $total->sum("total_price");
		$online = 0;
		$offline = 0;
		$online_total = 0;
		$offline_total = 0;

		foreach ($orders as $order) {
			if ($order->type == "online") {
				$online += 1;
				$online_total += $order->total_price;
			} else {
				$offline += 1;
				$offline_total += $order->total_price;
			}
		}

		return view("dashboard.order.index", [
			"orders" => $orders,
			"total" => $total,
			"online" => $online . " ( " . $online_total . " جنية )",
			"offline" => $offline . " ( " . $offline_total . " جنية )",
		]);
	}
}
