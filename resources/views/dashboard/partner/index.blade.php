@extends('dashboard.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="{{ asset('dashboard/css/dataTables.bootstrap4.css') }}">
@endsection

@section('title', 'الشركاء')

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

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="row col-12">
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <span class="card-title">رأس المال</span>
                        </div>
                        <div class="card-body my-n1">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ number_format($partners->sum('capital'), 2) }} جنية</h4>
                                </div>
                                <div class="flex-fill text-right">
                                    <span class="sparkline inlinebar"><canvas width="40" height="32"
                                            style="display: inline-block; width: 40px; height: 32px; vertical-align: top;"></canvas></span>
                                </div>
                            </div>
                        </div> <!-- .card-body -->
                    </div> <!-- .card -->
                </div>
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <span class="card-title">الارباح</span>
                        </div>
                        <div class="card-body my-n1">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ number_format($partners->sum('profits'), 2) }} جنية</h4>
                                </div>
                                <div class="flex-fill text-right">
                                    <span class="sparkline inlinebar"><canvas width="40" height="32"
                                            style="display: inline-block; width: 40px; height: 32px; vertical-align: top;"></canvas></span>
                                </div>
                            </div>
                        </div> <!-- .card-body -->
                    </div> <!-- .card -->
                </div>
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <span class="card-title">عدد الشركاء</span>
                        </div>
                        <div class="card-body my-n1">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ count($partners) }}</h4>
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
                        <h2 class="page-title">اضافة شريك</h2>
                    </div>
                </div>
                @error('capital')
                    <p style="color: red">* {{ $message }}</p>
                @enderror
                <form action="{{ route('dashboard.partner.store') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="name" value="{{ old('name') }}" class="form-control"
                            placeholder="الاسم">
                        <input type="number" value="{{ old('capital') }}" name="capital" class="form-control"
                            placeholder="رأس المال (جنية)">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">اضافة</button>
                        </div>
                    </div>
                </form>
                <div class="row align-items-center my-3">
                    <div class="col">
                        <h2 class="page-title">اضافة رأس مال</h2>
                    </div>
                </div>
                <form action="{{ route('dashboard.partner.capital.store') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="number" value="{{ old('amount') }}" name="amount" class="form-control"
                            placeholder="رأس المال (جنية)">
                        <select name="partner_id" class="form-control">
                            <option value="all">الجميع</option>
                            @foreach ($partners as $partner)
                                <option value="{{ $partner->id }}">{{ $partner->name }}</option>
                            @endforeach
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">اضافة</button>
                        </div>
                    </div>
                </form>
                <div class="row align-items-center my-3">
                    <div class="col">
                        <h2 class="page-title">الشركاء</h2>
                        <form method="post"
                            action="{{ route('dashboard.partner.payProfits.store', ['payall' => 1, 'amount' => $partners->sum('profits')]) }}">
                            @csrf
                            <button type="submit" class="btn btn btn-info mb-2">صرف
                                الارباح</button>
                        </form>
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
                                            <th>رأس المال</th>
                                            <th>النسبة</th>
                                            <th>الارباح</th>
                                            <th>حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($partners as $partner)
                                            <tr>
                                                <td>
                                                    <span>{{ $partner->name }}</span>
                                                    <div class="card-body">
                                                        <form id="partner_name_{{ $partner->id }}" class="form-inline"
                                                            method="POST"
                                                            action="{{ route('dashboard.partner.update', ['partner' => $partner->id]) }}">
                                                            @csrf
                                                            @method('put')
                                                            <input name="name" type="text"
                                                                class="form-control mb-2 mr-sm-2" placeholder="الاسم"
                                                                value="{{ $partner->name }}">
                                                            <button for="partner_name_{{ $partner->id }}" type="submit"
                                                                class="btn btn-sm btn-warning mb-2">تعديل</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ number_format($partner->capital, 2) }} جنية
                                                </td>
                                                <td>{{ $partner->ratio() }} %</td>
                                                <td>{{ number_format($partner->profits, 2) }} جنية</td>
                                                <td>
                                                    <form method="post"
                                                        action="{{ route('dashboard.partner.destroy', ['partner' => $partner->id]) }}">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit"
                                                            class="btn btn-sm btn-danger mb-2">حذف</button>
                                                    </form>
                                                    <form method="post"
                                                        action="{{ route('dashboard.partner.payProfits.store', ['partner_id' => $partner->id, 'payall' => 0, 'amount' => $partner->profits]) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-info mb-2">صرف
                                                            الارباح</button>
                                                    </form>
                                                    <a
                                                        href="{{ route('dashboard.partner.show', ['partner' => $partner->id]) }}"><button
                                                            class="btn btn-sm btn-warning">سجل الارباح</button></a>
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
