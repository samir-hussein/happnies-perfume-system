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
			$orders_analysis_data->select(
				DB::raw("YEAR(orders.updated_at) as year"),
				DB::raw("COUNT(DISTINCT orders.id) as orders"),
				"type",
				DB::raw("SUM(orders.total_price) as total_price")
			)->groupBy(DB::raw("YEAR(orders.updated_at)"), 'type');

			$profits_analysis_data->select(
				DB::raw("SUM(o.qty * o.unit_price) as total_unit_price"),
				DB::raw("YEAR(orders.updated_at) as year")
			)->groupBy(DB::raw("YEAR(orders.updated_at)"));

			$miscellaneous_expenses = Safe::where("purpose", "miscellaneous")
				->where("amount", "<", 0)
				->select(
					DB::raw("SUM(amount * -1) as expenses"),
					DB::raw("YEAR(created_at) as year")
				)->groupBy(DB::raw("YEAR(created_at)"))->get();
		}

		if ($analysis == "month") {
			$orders_analysis_data->select(
				DB::raw("MONTH(orders.updated_at) as month"),
				DB::raw("COUNT(DISTINCT orders.id) as orders"),
				"type",
				DB::raw("SUM(orders.total_price) as total_price")
			)->groupBy(DB::raw("MONTH(orders.updated_at)"), 'type')
				->whereYear('orders.updated_at', $year);

			$profits_analysis_data->select(
				DB::raw("SUM(o.qty * o.unit_price) as total_unit_price"),
				DB::raw("MONTH(orders.updated_at) as month")
			)->groupBy(DB::raw("MONTH(orders.updated_at)"))
				->whereYear('orders.updated_at', $year);

			$miscellaneous_expenses = Safe::whereYear('created_at', $year)
				->where("purpose", "miscellaneous")
				->where("amount", "<", 0)
				->select(
					DB::raw("SUM(amount * -1) as expenses"),
					DB::raw("MONTH(created_at) as month")
				)->groupBy(DB::raw("MONTH(created_at)"))->get();
		}

		if ($analysis == "day") {
			$monthDate = \Carbon\Carbon::createFromFormat('Y-m', $month);

			$orders_analysis_data->select(
				DB::raw("DAY(orders.updated_at) as day"),
				DB::raw("COUNT(DISTINCT orders.id) as orders"),
				"type",
				DB::raw("SUM(orders.total_price) as total_price")
			)->groupBy(DB::raw("DAY(orders.updated_at)"), 'type')
				->whereYear('orders.updated_at', $monthDate->year)
				->whereMonth('orders.updated_at', $monthDate->month);

			$profits_analysis_data->select(
				DB::raw("SUM(o.qty * o.unit_price) as total_unit_price"),
				DB::raw("DAY(orders.updated_at) as day")
			)->groupBy(DB::raw("DAY(orders.updated_at)"))
				->whereYear('orders.updated_at', $monthDate->year)
				->whereMonth('orders.updated_at', $monthDate->month);
		}

		$orders_analysis_data = $orders_analysis_data->get();
		$profits_analysis_data = $profits_analysis_data->get();

		$orders_analysis_data_sorted = [];
		$miscellaneous_expenses_sorted = [];

		foreach ($orders_analysis_data as $data) {
			if ($analysis == "year") {
				$category = $data['year'];
			} elseif ($analysis == "month") {
				$category = date("M", mktime(0, 0, 0, $data['month'], 1));
			} else {
				$category = $data['day'];
			}

			if (!in_array($category, $categories)) {
				$categories[] = $category;
			}

			$orders_analysis_data_sorted[$category][] = $data;
		}

		if (isset($miscellaneous_expenses)) {
			foreach ($miscellaneous_expenses as $data) {
				$category = $data['year'] ?? $data['month'] ?? $data['day'];
				$miscellaneous_expenses_sorted[$category] = $data;
			}
		}

		foreach ($profits_analysis_data as $data) {
			if ($analysis == "year") {
				$category = $data['year'];
			} elseif ($analysis == "month") {
				$category = date("M", mktime(0, 0, 0, $data['month'], 1));
			} else {
				$category = $data['day'];
			}

			$orders_analysis_data_sorted[$category]["total_unit_price"] = $data['total_unit_price'];
		}

		foreach ($orders_analysis_data_sorted as $data) {
			$orders_chart_data[] = isset($data[1]) ? $data[0]['orders'] + $data[1]['orders'] : $data[0]['orders'];
			$orders_chart_price[] = isset($data[1]) ? $data[0]['total_price'] + $data[1]['total_price'] : $data[0]['total_price'];

			if ($analysis != "day") {
				$calc_profit = isset($data[1]) ? round(($data[0]['total_price'] + $data[1]['total_price']) - $data['total_unit_price'], 2) : round(($data[0]['total_price'] - $data['total_unit_price']), 2);

				$profits_chart[] = $calc_profit - ($miscellaneous_expenses_sorted[$data[0]['month'] ?? $data[0]['year']]['expenses'] ?? 0);
			} else {
				$profits_chart[] = isset($data[1]) ? round(($data[0]['total_price'] + $data[1]['total_price']) - $data['total_unit_price'], 2) : round(($data[0]['total_price'] - $data['total_unit_price']), 2);
			}

			if ($data[0]['type'] == "online") {
				$online_chart_data[] = $data[0]['orders'];
				$online_chart_price[] = $data[0]['total_price'];
			}

			if ($data[0]['type'] == "offline") {
				$offline_chart_data[] = $data[0]['orders'];
				$offline_chart_price[] = $data[0]['total_price'];
			}

			if (isset($data[1])) {
				if ($data[1]['type'] == "online") {
					$online_chart_data[] = $data[1]['orders'];
					$online_chart_price[] = $data[1]['total_price'];
				}

				if ($data[1]['type'] == "offline") {
					$offline_chart_data[] = $data[1]['orders'];
					$offline_chart_price[] = $data[1]['total_price'];
				}
			}

			if (count($online_chart_data) < count($offline_chart_data)) {
				$online_chart_data[] = 0;
				$online_chart_price[] = 0;
			}

			if (count($online_chart_data) > count($offline_chart_data)) {
				$offline_chart_data[] = 0;
				$offline_chart_price[] = 0;
			}
		}

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
