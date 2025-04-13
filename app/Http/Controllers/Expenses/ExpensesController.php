<?php

namespace App\Http\Controllers\Expenses;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function index(Request $request)
    {
        return Index::boot($request);
    }

    public function store(Request $request)
    {
        return Store::boot($request);
    }
}
