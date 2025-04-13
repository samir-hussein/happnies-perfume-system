@extends('dashboard.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="{{ asset('dashboard/css/dataTables.bootstrap4.css') }}">
@endsection

@section('title', 'الخزنة')

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

    @error('description')
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
    @enderror

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="row col-12">
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <span class="card-title">المبلغ المتوفر بالخزنة</span>
                        </div>
                        <div class="card-body my-n1">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ number_format($total, 2) }} جنية</h4>
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
                            <span class="card-title">رأس المال</span>
                        </div>
                        <div class="card-body my-n1">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ number_format($capital, 2) }} جنية</h4>
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
                                    <h4 class="mb-0">{{ number_format($profits, 2) }} جنية</h4>
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
                        <h2 class="page-title">ايداع مبلغ</h2>
                    </div>
                </div>
                <form action="{{ route('dashboard.safe.store') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <input type="number" name="amount" class="form-control mb-2" placeholder="المبلغ">
                        <textarea name="description" class="form-control mb-2" id="" placeholder="الوصف" rows="2"></textarea>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">ايداع</button>
                        </div>
                    </div>
                </form>
                <div class="row align-items-center my-3">
                    <div class="col">
                        <h2 class="page-title">سجل التعاملات</h2>
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
                                            <th>المبلغ</th>
                                            <th>الوصف</th>
                                            <th>نوع المعاملة</th>
                                            <th>المصدر</th>
                                            <th>التاريخ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($records as $record)
                                            <tr>
                                                <td>{{ number_format($record->amount < 0 ? $record->amount * -1 : $record->amount, 2) }}
                                                    جنية</td>
                                                <td>{{ $record->description }}</td>
                                                <td>{{ $record->amount < 0 ? 'صرف' : 'ايداع' }}</td>
                                                <td>{{ $record->source == 'profits' ? 'الارباح' : ($record->source == 'capital' ? 'رأس المال' : '') }}
                                                </td>
                                                <td>{{ $record->created_at->format('Y-m-d H:i a') }}</td>
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
