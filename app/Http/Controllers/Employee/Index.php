<?php

namespace App\Http\Controllers\Employee;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Index extends Controller
{
    public static function boot()
    {
        return view("dashboard.employee.index", [
            "employees" => Employee::all(),
            "total_salaries" => Employee::sum("salary")
        ]);
    }
}
