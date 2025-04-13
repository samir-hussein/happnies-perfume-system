@extends('dashboard.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="{{ asset('dashboard/css/dataTables.bootstrap4.css') }}">
@endsection

@section('title', 'طلبات اون لاين')

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="row col-12">
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <span class="card-title">اجمالى مبيعات الطلبات</span>
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
                <div class="col-md-6 col-xl-3 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <span class="card-title">اجمالى الطلبات</span>
                        </div>
                        <div class="card-body my-n1">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ count($orders) }}</h4>
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
                        <h2 class="page-title">سجل الطلبات</h2>
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
                                            <th>#</th>
                                            <th>اسم العميل</th>
                                            <th>رقم هاتف العميل</th>
                                            <th>اسم الموظف</th>
                                            <th>المبلغ</th>
                                            <th>تاريخ التوصيل</th>
                                            <th>عمليات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $order)
                                            <tr>
                                                <td>{{ $order->id }}</td>
                                                <td>{{ $order->client_name }}</td>
                                                <td>{{ $order->phone }}</td>
                                                <td>{{ $order->employee }}</td>
                                                <td>{{ number_format($order->total_price, 2) }} جنية</td>
                                                <td>{{ $order->delivery_date }}</td>
                                                <td>
                                                    <a href="{{ route('order.online.show', ['order' => $order->id]) }}">
                                                        <button class="btn btn-sm btn-warning">تفاصيل</button>
                                                    </a>
                                                    <a href="{{ route('order.online.done', ['order' => $order->id]) }}">
                                                        <button class="btn btn-sm btn-success">تم التوصيل</button>
                                                    </a>
                                                    <form
                                                        action="{{ route('order.online.cancel', ['order' => $order->id]) }}"
                                                        class="d-inline" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-sm btn-danger">الغاء</button>
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
        let dataTable = $('#dataTable-1').DataTable({
            autoWidth: true,
            order: []
        });

        $('.dataTables_filter label').replaceWith(
            `
            <div class="input-group">
                <div class="input-group-prepend">
                    <select class="form-control" id="searchColumn">
                        <option value="0">رقم الفاتورة</option>
                        <option value="2">اسم العميل</option>
                        <option value="3">رقم العميل</option>
                        <option value="4">اسم الموظف</option>
                        <option value="5">المبلغ</option>
                        <option value="6">تاريخ التوصيل</option>
                    </select>
                </div>
                <input type="search" class="form-control" placeholder="بحث">
            </div>
            `
        );
        var lastSelectedColumn = 0; // Variable to store the last selected column index

        // Add event listener for column select change
        $('#searchColumn').on('change', function() {
            dataTable.column(lastSelectedColumn).search("").draw();
            lastSelectedColumn = parseInt($(this).val());
            performSearch();
        });

        // Handle keyup event for the search input
        $('.dataTables_filter input[type="search"]').on('keyup', function() {
            performSearch();
        });

        // Function to perform search
        function performSearch() {
            var searchText = $('.dataTables_filter input[type="search"]').val();
            dataTable.column(lastSelectedColumn).search(searchText).draw();
        }
    </script>
@endsection
