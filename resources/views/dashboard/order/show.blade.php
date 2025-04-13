@extends('dashboard.layouts.main-layout')

@section('title', 'الفاتورة')

@section('style')
    <style>
        .hide {
            display: none;
            color: white;
            background-color: rgb(70, 70, 70) !important;
        }
    </style>
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    <div id="div-errors">

    </div>

    <div class="row">
        <div class="col-12">
            <div class="row align-items-center my-3">
                <div class="col">
                    <h2 class="page-title">بيانات الفاتورة</h2>
                </div>
                <div class="col-auto">
                    <a href="{{ route('dashboard.order.index') }}" class="btn btn-dark"><span
                            class="fe fe-arrow-right fe-16 mr-3"></span>العودة</a>
                </div>
            </div>
        </div>
        <div class="col-md-6 my-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">قائمة المنتجات</h5>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>سعر الجملة</th>
                                <th>سعر البيع</th>
                                <th>الكمية</th>
                                <th>الخصم</th>
                            </tr>
                        </thead>
                        <tbody id="table-body-gather">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->unit_price }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ $item->discount }} {{ $item->discount_type == 'amount' ? 'جنية' : '%' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-6 my-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">فاتورة رقم : {{ $order->id }}</h5>
                    <h5 class="card-title">{{ $order->type == 'offline' ? 'بيع مباشر' : 'فاتورة اون لاين' }}</h5>
                    <h5 class="card-title">{{ $order->created_at->format('Y-m-d H:i a') }}</h5>
                    <div class="d-flex mb-2 align-items-center">
                        <label class="w-25">اسم الموظف</label>
                        <input id="name" type="text" class="form-control" value="{{ $order->employee }}" disabled>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>اسم العميل</label>
                            <input id="name" type="text" class="form-control" value="{{ $order->client_name }}"
                                disabled>
                        </div>
                        <div class="col">
                            <label>رقم هاتف العميل</label>
                            <input type="text" id="phone" class="form-control" value="{{ $order->phone }}" disabled>
                        </div>
                    </div>
                    @if ($order->delivery_date || $order->delivery_price || $order->delivery_place)
                        <div class="row mb-2">
                            <div class="col">
                                <label>مصاريف الشحن (جنية)</label>
                                <input type="text" class="form-control" value="{{ $order->delivery_price }}" disabled>
                            </div>
                            <div class="col">
                                <label>تاريخ الشحن</label>
                                <input type="date" class="form-control" value="{{ $order->delivery_date }}" disabled>
                            </div>
                        </div>
                        <label>مكان التوصيل</label>
                        <textarea class="form-control" disabled>{{ $order->delivery_place }}</textarea>
                        <label>ملاحظات</label>
                        <textarea class="form-control" disabled>{{ $order->note }}</textarea>
                    @endif
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>السعر</th>
                                <th>الكمية</th>
                            </tr>
                        </thead>
                        <tbody id="table-body-invoice">
                            @foreach ($order->invoice as $item)
                                <tr data-id="{{ $item->code }}" class="invoice-list">
                                    <td>{{ $item->code }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->qty }}</td>
                                </tr>
                                @if (isset($gather[$item->code]))
                                    @foreach ($gather[$item->code] as $row)
                                        <tr class="{{ $item->code }} hide">
                                            <td>{{ $row->code }}</td>
                                            <td>{{ $row->name }}</td>
                                            <td>{{ $row->price }}</td>
                                            <td>{{ $row->qty }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right">الاجمالى</td>
                                <td colspan="2" class="text-right"><span id="total">{{ $order->price }}</span>
                                    جنية</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">الخصم</td>
                                <td colspan="2" class="text-right"><span id="td-disc">{{ $order->discount }}</span>
                                    <span id="td-disc-type">{{ $order->discount_type == 'amount' ? 'جنية' : '%' }}</span>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">السعر بعد الخصم</td>
                                <td colspan="2" class="text-right"><span
                                        id="total_after_discount">{{ $order->total_price }}</span> جنية</td>
                            </tr>
                            @if ($order->delivery_price)
                                <tr>
                                    <td colspan="3" class="text-right">مصاريف الشحن</td>
                                    <td colspan="2" class="text-right"><span
                                            id="total_after_discount">{{ $order->delivery_price }}</span> جنية</td>
                                </tr>
                            @endif
                            <tr>
                                <td></td>
                                <td></td>
                                <td colspan="2" class="text-right w-50">
                                    <button id="pay_print" class="btn btn btn-warning w-100"
                                        onclick="printInvoice('printableDiv')">طباعة</button>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div id="printableDiv" style="display: none">
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Document</title>
            <style>
                @font-face {
                    font-family: arabic;
                    src: url("{{ asset('fonts/Tajawal-Bold.ttf') }}");
                }

                * {
                    font-family: arabic;
                }

                #invoice-table {
                    width: 100%;
                    border-collapse: collapse;
                    font-size: 12px;
                    font-family: 'Cairo', sans-serif;
                    direction: rtl;
                    text-align: center;
                }

                #invoice-table tr {
                    border-bottom: 1px solid #ccc;
                }

                #invoice-table td,
                #invoice-table th {
                    padding: 5px;
                }
            </style>
        </head>

        <body dir="rtl">
            <div style="text-align: center">
                <img src="{{ asset('images/logo.png') }}" alt="logo" width="100">
            </div>
            <div dir="rtl">
                <h5>رقم الفاتورة : <span id="invoice_order_id">{{ $order->id }}</span></h5>
                <h5>تاريخ الاصدار : <span id="invoice_order_date">{{ $order->created_at->format('Y-m-d H:i a') }}</span>
                </h5>
                <h5>اسم الموظف : <span id="invoice_employee">{{ $order->employee }}</span></h5>
                <h5>اسم العميل : <span id="invoice_client">{{ $order->client_name }}</span></h5>
                <h5>رقم هاتف العميل : <span>{{ $order->phone }}</span></h5>
                @if ($order->delivery_place)
                    <h5>مكان التوصيل : <span>{{ $order->delivery_place }}</span></h5>
                @endif
            </div>
            <div>
                <table id="invoice-table">
                    <thead>
                        <th>#</th>
                        <th>المنتج</th>
                        <th>السعر</th>
                        <th>الكمية</th>
                        <th>الاجمالى</th>
                    </thead>
                    <tbody id="invoice-body">
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($order->invoice as $item)
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->price }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ $item->qty * $item->price }}</td>
                            </tr>
                            @php
                                $i++;
                            @endphp
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <th colspan="2">الاجمالى</th>
                            <th><span id="invoice-total">{{ $order->price }}</span> جنية</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <th colspan="2">الخصم</th>
                            <th id="invoice-disc">{{ $order->discount }}
                                {{ $order->discount_type == 'amount' ? 'جنية' : '%' }}</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <th colspan="2">السعر بعد الخصم</th>
                            <th><span id="invoice-after-disc">{{ $order->total_price }}</span> جنية</th>
                        </tr>
                        @if ($order->delivery_price)
                            <tr>
                                <td></td>
                                <td></td>
                                <th colspan="2">مصاريف الشحن</th>
                                <th><span id="invoice-after-disc">{{ $order->delivery_price }}</span> جنية</th>
                            </tr>
                        @endif
                    </tfoot>
                </table>
            </div>
        </body>

        </html>
    </div>
@endsection

@section('script')
    <script>
        function printInvoice(divId) {
            // Save the original content of the document body
            const originalContent = document.body.innerHTML;

            // Get the content of the div to be printed
            const divContent = document.getElementById(divId).innerHTML;

            // Open a new window
            var printWindow = window.open('', '', 'height=700,width=900');

            printWindow.document.write(divContent);

            // Close the document to finish loading the content
            printWindow.document.close();

            // Wait for the content to load and then print
            printWindow.onload = function() {
                printWindow.focus(); // Ensure the print window is focused
                printWindow.print(); // Trigger the print dialog
                setTimeout(function() {
                    printWindow.close(); // Close the window after a delay to allow the print dialog to appear
                }, 1000); // Adjust the delay as needed
            };
        }

        $(document).on('click', ".invoice-list", function() {
            let id = $(this).data('id');
            $("." + id).toggle("slow");
        });
    </script>
@endsection
