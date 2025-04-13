<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class Destroy extends Controller
{
    public static function boot(Employee $employee)
    {
        $employee->delete();

        return back()->with("success", "تم الحذف بنجاح");
    }
}
