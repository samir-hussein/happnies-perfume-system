<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class Store extends Controller
{
    public static function boot(string|null $name, string|null $phone)
    {
        if ($phone && $phone != "") {
            $client = Client::where("phone", $phone)->first();

            if (!$client) {
                Client::create([
                    "name" => $name,
                    "phone" => $phone,
                    "times_buy" => 1,
                ]);
            } else {
                $client->times_buy += 1;
                $client->save();
            }
        }
    }
}
