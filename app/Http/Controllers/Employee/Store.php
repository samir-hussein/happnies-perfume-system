<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class Store extends Controller
{
    public static function boot(Request $request)
    {
        $validated = $request->validate([
            "name" => "required|unique:employees,name",
            "salary" => "required|numeric|min:0",
            "work_days" => "required|numeric|min:1|max:7",
            "work_hours" => "required|numeric|min:1|max:24",
        ]);

        Employee::create($validated);

        return back()->with("success", "تم الاضافة بنجاح");
    }
}
