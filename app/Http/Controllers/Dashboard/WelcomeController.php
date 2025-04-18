<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Safe;
use App\Models\Order;
use App\Models\Partner;
use App\Models\ProductQty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Product\Warning;
use App\Http\Controllers\Notification\NotificationController;
use App\Models\OrderItem;

class WelcomeController extends Controller
{
	public function index(Request $request)
	{
		$warningList = Warning::boot();
		NotificationController::store($warningList);
		$list = NotificationController::alertList();
		NotificationController::markAlertList($list);

		$analysis = $request->analysis ?? "day";
		$year = $request->year ?? date("Y");
		$month = $request->month ?? date("Y-m");

		$products_capital = ProductQty::select(DB::raw('sum(qty * price) as total'))->first()->total;
		$capital = Partner::sum("capital");
		$profits = Partner::sum("profits");
		$safe = Safe::sum("amount");
		$safe_capital = $safe - $profits;
		$total_sell = Order::where("status", "finished")->where("updated_at", ">=", date("Y-m"))->sum("total_price");
		$expenses = Safe::where("amount", "<", 0)->where("created_at", ">=", date("Y-m"))->sum("amount") * -1;

		$online_orders_capital = OrderItem::select(DB::raw('sum(qty * unit_price) as total'))
			->join("orders", "orders.id", "order_items.order_id")
			->where("orders.status", "pendding")
			->first()
			->total;

		$categories = [];
		$orders_chart_data = [];
		$online_chart_data = [];
		$offline_chart_data = [];
		$orders_chart_price = [];
		$online_chart_price = [];
		$offline_chart_price = [];
		$profits_chart = [];
		$orders_analysis_data = Order::query()->where("status", "finished");
		$profits_analysis_data = Order::query()->join("order_items as o", "orders.id", "o.order_id")->where("status", "finished");

		if ($analysis == "year") {
			$orders_analysis_data->select(DB::raw("DATE_FORMAT(orders.updated_at, '%Y') as year"), DB::raw("COUNT(DISTINCT orders.id) as orders"), "type", DB::raw("SUM(orders.total_price) as total_price"))
				->groupBy(DB::raw("DATE_FORMAT(orders.updated_at, '%Y')"), 'type');

			$profits_analysis_data->select(DB::raw("SUM(o.qty * o.unit_price) as total_unit_price"), DB::raw("DATE_FORMAT(orders.updated_at, '%Y') as year"))
				->groupBy(DB::raw("DATE_FORMAT(orders.updated_at, '%Y')"));

			$miscellaneous_expenses = Safe::where("purpose", "miscellaneous")->where("amount", "<", 0)
				->select(DB::raw("SUM(amount * -1) as expenses"), DB::raw("DATE_FORMAT(created_at, '%Y') as year"))
				->groupBy(DB::raw("DATE_FORMAT(created_at, '%Y')"))
				->get();
		}

		if ($analysis == "month") {
			$orders_analysis_data->select(DB::raw("DATE_FORMAT(orders.updated_at, '%m') as month"), DB::raw("COUNT(DISTINCT orders.id) as orders"), "type", DB::raw("SUM(orders.total_price) as total_price"))
				->groupBy(DB::raw("DATE_FORMAT(orders.updated_at, '%m')"), 'type')
				->where(DB::raw("DATE_FORMAT(orders.updated_at, '%Y')"), $year);

			$profits_analysis_data->select(DB::raw("SUM(o.qty * o.unit_price) as total_unit_price"), DB::raw("DATE_FORMAT(orders.updated_at, '%m') as month"))
				->groupBy(DB::raw("DATE_FORMAT(orders.updated_at, '%m')"))
				->where(DB::raw("DATE_FORMAT(orders.updated_at, '%Y')"), $year);

			$miscellaneous_expenses = Safe::where(DB::raw("DATE_FORMAT(created_at, '%Y')"), $year)
				->where("purpose", "miscellaneous")->where("amount", "<", 0)
				->select(DB::raw("SUM(amount * -1) as expenses"), DB::raw("DATE_FORMAT(created_at, '%m') as month"))
				->groupBy(DB::raw("DATE_FORMAT(created_at, '%m')"))
				->get();
		}

		if ($analysis == "day") {
			$orders_analysis_data->select(DB::raw("DATE_FORMAT(orders.updated_at, '%d') as day"), DB::raw("COUNT(DISTINCT orders.id) as orders"), "type", DB::raw("SUM(orders.total_price) as total_price"))
				->groupBy(DB::raw("DATE_FORMAT(orders.updated_at, '%d')"), 'type')
				->where(DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m')"), $month);

			$profits_analysis_data->select(DB::raw("SUM(o.qty * o.unit_price) as total_unit_price"), DB::raw("DATE_FORMAT(orders.updated_at, '%d') as day"))
				->groupBy(DB::raw("DATE_FORMAT(orders.updated_at, '%d')"))
				->where(DB::raw("DATE_FORMAT(orders.updated_at, '%Y-%m')"), $month);
		}

		$orders_analysis_data = $orders_analysis_data->get();
		$profits_analysis_data = $profits_analysis_data->get();

		// The rest of the code stays the same

		dd([
			"alertList" => $list,
			"capital" => $capital,
			"profits" => $profits,
			"safe" => $safe,
			"safe_capital" => $safe_capital,
			"expenses" => $expenses,
			"total_sell" => $total_sell,
			'products_capital' => $products_capital,
			'online_orders_capital' => $online_orders_capital,
			"month" => date("m"),
			"year" => date("Y"),
			"month_name" => date("F"),
			"year_name" => date("Y"),
			"categories" => $categories,
			"orders_chart_data" => $orders_chart_data,
			"online_chart_data" => $online_chart_data,
			"offline_chart_data" => $offline_chart_data,
			"orders_chart_price" => $orders_chart_price,
			"online_chart_price" => $online_chart_price,
			"offline_chart_price" => $offline_chart_price,
			"profits_chart" => $profits_chart,
		]);

		return view('dashboard.welcome', [
			"alertList" => $list,
			"capital" => $capital,
			"profits" => $profits,
			"safe" => $safe,
			"safe_capital" => $safe_capital,
			"expenses" => $expenses,
			"total_sell" => $total_sell,
			'products_capital' => $products_capital,
			'online_orders_capital' => $online_orders_capital,
			"month" => date("m"),
			"year" => date("Y"),
			"month_name" => date("F"),
			"year_name" => date("Y"),
			"categories" => $categories,
			"orders_chart_data" => $orders_chart_data,
			"online_chart_data" => $online_chart_data,
			"offline_chart_data" => $offline_chart_data,
			"orders_chart_price" => $orders_chart_price,
			"online_chart_price" => $online_chart_price,
			"offline_chart_price" => $offline_chart_price,
			"profits_chart" => $profits_chart,
		]);
	}
}
