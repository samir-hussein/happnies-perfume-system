<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class Index extends Controller
{
    public static function boot(Request $request)
    {
        $clients = Client::query();

        if ($request->times_buy) {
            $clients->where("times_buy", ">=", $request->times_buy);
        }

        $clients = $clients->latest()->get();

        return view("dashboard.client.index", [
            "clients" => $clients,
        ]);
    }
}
