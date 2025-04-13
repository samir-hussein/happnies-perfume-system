@extends('dashboard.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="{{ asset('dashboard/css/dataTables.bootstrap4.css') }}">
@endsection

@section('title', 'الموظفيين')

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    @error('name')
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
    @enderror

    @error('salary')
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
    @enderror

    @error('work_days')
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
    @enderror

    @error('work_hours')
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
    @enderror

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="row col-12">
                <div class="col-md-6 col-xl-6 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <span class="card-title">عدد الموظفيين</span>
                        </div>
                        <div class="card-body my-n1">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ count($employees) }}</h4>
                                </div>
                                <div class="flex-fill text-right">
                                    <span class="sparkline inlinebar"><canvas width="40" height="32"
                                            style="display: inline-block; width: 40px; height: 32px; vertical-align: top;"></canvas></span>
                                </div>
                            </div>
                        </div> <!-- .card-body -->
                    </div> <!-- .card -->
                </div>
                <div class="col-md-6 col-xl-6 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <span class="card-title">اجمالى الرواتب</span>
                        </div>
                        <div class="card-body my-n1">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <h4 class="mb-0">
                                        {{ number_format($total_salaries, 2) }}
                                        جنية</h4>
                                </div>
                                <div class="flex-fill text-right">
                                    <span class="sparkline inlinebar"><canvas width="40" height="32"
                                            style="display: inline-block; width: 40px; height: 32px; vertical-align: top;"></canvas></span>
                                </div>
                            </div>
                        </div> <!-- .card-body -->
                    </div> <!-- .card -->
                </div>
            </div>
            <div class="col-12">
                <div class="row align-items-center my-3">
                    <div class="col">
                        <h2 class="page-title">اضافة موظف</h2>
                    </div>
                </div>
                <form action="{{ route('dashboard.employee.store') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" value="{{ old('name') }}" name="name" class="form-control"
                            placeholder="اسم الموظف">
                        <input type="text" name="salary" value="{{ old('salary') }}" class="form-control"
                            placeholder="الراتب (جنية)">
                        <input type="text" name="work_days" value="{{ old('work_days') }}" class="form-control"
                            placeholder="عدد ايام العمل / الاسبوع">
                        <input type="text" name="work_hours" value="{{ old('work_hours') }}" class="form-control"
                            placeholder="عدد ساعات العمل / اليوم">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">اضافة</button>
                        </div>
                    </div>
                </form>
                <div class="row align-items-center my-3">
                    <div class="col">
                        <h2 class="page-title">الموظفيين</h2>
                    </div>
                </div>
                <div class="row my-4">
                    <!-- Small table -->
                    <div class="col-md-12">
                        <div class="card shadow">
                            <div class="card-body">
                                <!-- table -->
                                <table class="table datatables" id="dataTable-1">
                                    <thead>
                                        <tr>
                                            <th>الاسم</th>
                                            <th>الراتب</th>
                                            <th>عدد ايام العمل / الاسبوع</th>
                                            <th>عدد ساعات العمل / اليوم</th>
                                            <th class="w-100 p-0">تاريخ البداية</th>
                                            <th>حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($employees as $employee)
                                            <tr>
                                                <td>
                                                    <span>{{ $employee->name }}</span>
                                                    <div class="card-body">
                                                        <form id="employee_{{ $employee->id }}" class="form-inline"
                                                            method="POST"
                                                            action="{{ route('dashboard.employee.update', ['employee' => $employee->id]) }}">
                                                            @csrf
                                                            @method('put')
                                                            <input name="name" type="text"
                                                                class="form-control mb-2 mr-sm-2" placeholder="الاسم"
                                                                value="{{ $employee->name }}">
                                                            <button for="employee_{{ $employee->id }}" type="submit"
                                                                class="btn btn-sm btn-warning mb-2">تعديل</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>{{ number_format($employee->salary, 2) }}</span>
                                                    <div class="card-body">
                                                        <form id="employee_salary_{{ $employee->id }}" class="form-inline"
                                                            method="POST"
                                                            action="{{ route('dashboard.employee.update', ['employee' => $employee->id]) }}">
                                                            @csrf
                                                            @method('put')
                                                            <input name="salary" type="text"
                                                                class="form-control mb-2 mr-sm-2" placeholder="الراتب"
                                                                value="{{ $employee->salary }}">
                                                            <button for="employee_salary_{{ $employee->id }}"
                                                                type="submit"
                                                                class="btn btn-sm btn-warning mb-2">تعديل</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>{{ $employee->work_days }}</span>
                                                    <div class="card-body">
                                                        <form id="employee_work_days_{{ $employee->id }}"
                                                            class="form-inline" method="POST"
                                                            action="{{ route('dashboard.employee.update', ['employee' => $employee->id]) }}">
                                                            @csrf
                                                            @method('put')
                                                            <input name="work_days" type="text"
                                                                class="form-control mb-2 mr-sm-2"
                                                                placeholder="عدد ايام العمل / الاسبوع"
                                                                value="{{ $employee->work_days }}">
                                                            <button for="employee_work_days_{{ $employee->id }}"
                                                                type="submit"
                                                                class="btn btn-sm btn-warning mb-2">تعديل</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span>{{ $employee->work_hours }}</span>
                                                    <div class="card-body">
                                                        <form id="employee_work_hours_{{ $employee->id }}"
                                                            class="form-inline" method="POST"
                                                            action="{{ route('dashboard.employee.update', ['employee' => $employee->id]) }}">
                                                            @csrf
                                                            @method('put')
                                                            <input name="work_hours" type="text"
                                                                class="form-control mb-2 mr-sm-2"
                                                                placeholder="عدد ساعات العمل / اليوم"
                                                                value="{{ $employee->work_hours }}">
                                                            <button for="employee_work_hours_{{ $employee->id }}"
                                                                type="submit"
                                                                class="btn btn-sm btn-warning mb-2">تعديل</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td class="w-100 p-0">{{ $employee->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <form method="post"
                                                        action="{{ route('dashboard.employee.destroy', ['employee' => $employee->id]) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger mb-2">حذف</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div> <!-- simple table -->
                </div> <!-- end section -->
            </div> <!-- .col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
@endsection

@section('script')
    <script src='{{ asset('dashboard/js/jquery.dataTables.min.js') }}'></script>
    <script src='{{ asset('dashboard/js/dataTables.bootstrap4.min.js') }}'></script>

    <script>
        $('#dataTable-1').DataTable({
            autoWidth: true,
            order: []
        });
    </script>
@endsection
