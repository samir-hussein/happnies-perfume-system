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

    @error('amount')
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
    @enderror

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center my-3">
                    <div class="col">
                        <h2 class="page-title">بيانات الشريك</h2>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('dashboard.partner.index') }}" class="btn btn-dark"><span
                                class="fe fe-arrow-right fe-16 mr-3"></span>العودة</a>
                    </div>
                </div>
                <div class="row align-items-center my-3">
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <div class="col">
                                <label for="name">الاسم</label>
                                <input disabled type="text" name="name" value="{{ $partner->name }}"
                                    class="form-control" placeholder="الاسم">
                            </div>
                            <div class="col">
                                <label>رأس المال</label>
                                <input disabled type="text" value="{{ number_format($partner->capital, 2) }} جنية"
                                    name="capital" class="form-control" placeholder="رأس المال (جنية)">
                            </div>
                            <div class="col">
                                <label for="name">النسبة</label>
                                <input disabled type="text" name="name" value="{{ $partner->ratio() }} %"
                                    class="form-control" placeholder="الاسم">
                            </div>
                            <div class="col">
                                <label for="name">الارباح المستحقة</label>
                                <input disabled type="text" name="name"
                                    value="{{ number_format($partner->profits, 2) }} جنية" class="form-control"
                                    placeholder="الاسم">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <h2 class="page-title">صرف الارباح</h2>
                    </div>
                </div>
                @error('capital')
                    <p style="color: red">* {{ $message }}</p>
                @enderror
                <form action="{{ route('dashboard.partner.payProfits.store') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="hidden" value="{{ $partner->id }}" name="partner_id">
                        <input type="hidden" value="0" name="payall">
                        <input type="text" name="amount" value="{{ $partner->profits }}" class="form-control"
                            placeholder="المبلغ">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">صرف</button>
                        </div>
                    </div>
                </form>
                <div class="row align-items-center my-3">
                    <div class="col">
                        <h2 class="page-title">سجل الارباح</h2>
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
                                            <th>الارباح</th>
                                            <th>تاريخ الصرف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($partner->profitsHistory as $profit)
                                            <tr>
                                                <td>{{ number_format($profit->amount, 2) }} جنية</td>
                                                <td>{{ $profit->created_at }}</td>
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
