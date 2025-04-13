@extends('dashboard.layouts.main-layout')

@section('title', 'لوحة التحكم')

@section('style')
    <style>
        .apexcharts-toolbar {
            display: none !important;
        }
    </style>
@endsection

@section('content')
    @if (count($alertList) > 0)
        <div class="col-12 mb-4">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                @foreach ($alertList as $msg)
                    <p>{{ $msg->text }}</p>
                @endforeach
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
        </div>
    @endif


    <div class="container-fluid">
        <div class="row justify-content-center">
            <h1><span class="fe fe-24 fe-chevrons-left"></span>{{ $year }} - {{ $month_name }}<span
                    class="fe fe-24 fe-chevrons-right"></span></h1>
            <div class="row col-12">
                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <span class="card-title">اجمالى رأس المال</span>
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
                            <span class="card-title">رأس المال (منتجات)</span>
                        </div>
                        <div class="card-body my-n1">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ number_format($products_capital, 2) }} جنية</h4>
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
                            <span class="card-title">رأس المال (نقدى بالخزنة)</span>
                        </div>
                        <div class="card-body my-n1">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ number_format($safe_capital, 2) }} جنية</h4>
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
                            <span class="card-title">رأس المال (منتجات طلبات أون لاين)</span>
                        </div>
                        <div class="card-body my-n1">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ number_format($online_orders_capital, 2) }} جنية</h4>
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
                            <span class="card-title">اجمالى المبيعات</span>
                        </div>
                        <div class="card-body my-n1">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ number_format($total_sell, 2) }} جنية</h4>
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
                            <span class="card-title">الخزنة</span>
                        </div>
                        <div class="card-body my-n1">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ number_format($safe, 2) }} جنية</h4>
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
                            <span class="card-title">الارباح (الخزنة)</span>
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

                <div class="col-md-6 col-xl-4 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <span class="card-title">المصروفات</span>
                        </div>
                        <div class="card-body my-n1">
                            <div class="d-flex">
                                <div class="flex-fill">
                                    <h4 class="mb-0">{{ number_format($expenses, 2) }} جنية</h4>
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

            <div class="mb-2 row w-100 d-flex align-items-center justify-content-between">
                <form action="{{ route('dashboard.home') }}" id="form-analysis">
                    <label>تصفية الاحصائيات</label>

                    <div class="row">
                        <div class="form-group mb-3 col">
                            <label for="analysis">نوع التقرير</label>
                            <select id="analysis" name="analysis" class="form-control">
                                <option {{ request('analysis') == 'day' ? 'selected' : '' }} value="day">يوم</option>
                                <option {{ request('analysis') == 'month' ? 'selected' : '' }} value="month">شهر</option>
                                <option {{ request('analysis') == 'year' ? 'selected' : '' }} value="year">سنة</option>
                            </select>
                        </div>
                        <div class="form-group mb-3 col" id="month-div">
                            <label for="month">شهر</label>
                            <input class="form-control" value="{{ request('month') ?? date('Y-m') }}" id="month"
                                type="month" name="month">
                        </div>
                        <div class="form-group mb-3 col" id="year-div">
                            <label for="year">سنة</label>
                            <input min="2000" step="1" class="form-control" placeholder="2024" id="year"
                                type="number" name="year" value="{{ request('year') ?? date('Y') }}">
                        </div>
                        <div class="form-group mb-3 col d-flex flex-column justify-content-end">
                            <button class="btn btn-sm btn-dark">عرض الاحصائيات</button>
                        </div>
                    </div>
                </form>
                <div>
                    <a href="{{ route('dashboard.report.index', ['year' => request('year') ?? date('Y')]) }}"
                        class="btn btn-success d-flex align-items-center"><span
                            class="fe fe-arrow-down-circle fe-16 mr-3"></span>تحميل التقرير الشهرى</a>
                </div>
            </div>

            <div class="col-12 mb-4 row">
                <div class="card shadow col">
                    <div class="card-header">
                        <strong class="card-title mb-0">الطلبات</strong>
                    </div>
                    <div class="card-body">
                        <div id="ordersChart"></div>
                    </div> <!-- /.card-body -->
                </div> <!-- /.card -->
                <div class="card shadow col">
                    <div class="card-header">
                        <strong class="card-title mb-0">المبيعات</strong>
                    </div>
                    <div class="card-body">
                        <div id="priceChart"></div>
                    </div> <!-- /.card-body -->
                </div> <!-- /.card -->
                <div class="card shadow col-12">
                    <div class="card-header">
                        <strong class="card-title mb-0">الارباح</strong>
                    </div>
                    <div class="card-body">
                        <div id="profitChart"></div>
                    </div> <!-- /.card-body -->
                </div> <!-- /.card -->
            </div> <!-- /. col -->
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/apexchart.js') }}"></script>

    <script>
        var options = {
            series: [{
                name: 'اوف لاين',
                group: 'two',
                data: JSON.parse('{!! json_encode($offline_chart_data) !!}'),
            }, {
                name: 'اون لاين',
                group: 'two',
                data: JSON.parse('{!! json_encode($online_chart_data) !!}'),
            }, {
                name: 'اجمالى الطلبات',
                group: 'one',
                data: JSON.parse('{!! json_encode($orders_chart_data) !!}'),
            }],
            chart: {
                type: 'bar',
                height: 500,
                stacked: true,
            },
            plotOptions: {
                bar: {
                    horizontal: false
                }
            },
            dataLabels: {
                enabled: true
            },
            stroke: {
                show: true,
                width: 4,
                colors: ['transparent']
            },
            xaxis: {
                categories: JSON.parse('{!! json_encode($categories) !!}'),
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left',
                offsetX: 40
            }
        };

        var optionsForPrice = {
            series: [{
                name: 'اوف لاين',
                group: 'budget',
                data: JSON.parse('{!! json_encode($offline_chart_price) !!}'),
            }, {
                name: 'اون لاين',
                group: 'budget',
                data: JSON.parse('{!! json_encode($online_chart_price) !!}'),
            }, {
                name: 'اجمالى المبيعات',
                group: 'actual',
                data: JSON.parse('{!! json_encode($orders_chart_price) !!}'),
            }],
            chart: {
                type: 'bar',
                height: 500,
                stacked: true,
            },
            plotOptions: {
                bar: {
                    horizontal: true
                }
            },
            dataLabels: {
                formatter: (val) => {
                    return val
                }
            },
            stroke: {
                width: 1,
                colors: ['#fff']
            },
            xaxis: {
                categories: JSON.parse('{!! json_encode($categories) !!}'),
                labels: {
                    formatter: function(val) {
                        return val + " جنية"
                    }
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " جنية"
                    }
                }
            },
            legend: {
                position: 'top',
                horizontalAlign: 'left',
                offsetX: 40
            }
        };

        var optionsForProfits = {
            series: [{
                name: "الارباح",
                data: JSON.parse('{!! json_encode($profits_chart) !!}'),
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'straight'
            },
            title: {
                text: 'Product Trends by Month',
                align: 'left'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: JSON.parse('{!! json_encode($categories) !!}'),
            },
            tooltip: {
                y: {
                    formatter: function(val) {
                        return val + " جنية"
                    }
                }
            }
        };

        var ordersChart = new ApexCharts(document.querySelector("#ordersChart"), options);
        ordersChart.render();

        var priceChart = new ApexCharts(document.querySelector("#priceChart"), optionsForPrice);
        priceChart.render();

        var profitChart = new ApexCharts(document.querySelector("#profitChart"), optionsForProfits);
        profitChart.render();



        $("#analysis").change(function() {
            let val = $(this).val();

            if (val == "day") {
                $("#month-div").css("display", "block");
                $("#year-div").css("display", "none");
            }

            if (val == "month") {
                $("#month-div").css("display", "none");
                $("#year-div").css("display", "block");
            }

            if (val == "year") {
                $("#month-div").css("display", "none");
                $("#year-div").css("display", "none");
            }
        })

        if ("{{ request('analysis') }}" == "day") {
            $("#month-div").css("display", "block");
            $("#year-div").css("display", "none");
        } else if ("{{ request('analysis') }}" == "month") {
            $("#month-div").css("display", "none");
            $("#year-div").css("display", "block");
        } else if ("{{ request('analysis') }}" == "year") {
            $("#month-div").css("display", "none");
            $("#year-div").css("display", "none");
        } else {
            $("#year-div").css("display", "none");
        }
    </script>
@endsection
