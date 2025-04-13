<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return Index::boot();
    }

    public function store(Request $request)
    {
        return Store::boot($request);
    }

    public function update(Request $request, Employee $employee)
    {
        return Update::boot($request, $employee);
    }

    public function destroy(Employee $employee)
    {
        return Destroy::boot($employee);
    }
}
