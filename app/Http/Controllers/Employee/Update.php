<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class Update extends Controller
{
    public static function boot(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            "name" => "sometimes|unique:employees,name," . $employee->id,
            "salary" => "sometimes|numeric|min:0",
            "work_days" => "sometimes|numeric|min:1|max:7",
            "work_hours" => "sometimes|numeric|min:1|max:24",
        ]);

        $employee->update($validated);

        return back()->with("success", "تم التحديث بنجاح");
    }
}
