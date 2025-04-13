<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        return Index::boot($request);
    }

    public static function store(string|null $name, string|null $phone)
    {
        return Store::boot($name, $phone);
    }
}
