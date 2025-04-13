@extends('layouts.main-layout')

@section('title', 'الصفحة الرئيسية')

@section('style')
    <style>
        #search-list {
            position: absolute;
            top: 60px;
            z-index: 100;
            width: 50%;
            max-height: 500px;
            overflow-y: scroll;
            overflow-x: hidden;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
            display: none;
        }

        /* For WebKit browsers (Chrome, Safari, Edge) */
        input[type="number"]::-webkit-outer-spin-button,
        input[type="number"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* For Firefox */
        input[type="number"] {
            -moz-appearance: textfield;
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

    <div class="col-12 my-4" id="search-list">
        <div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم</th>
                            <th>الكمية</th>
                            <th>السعر</th>
                            <th>الخصم</th>
                            <th>السعر بعد الخصم</th>
                            <th>اضافة</th>
                        </tr>
                    </thead>
                    <tbody id="table-body-search">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 my-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">تجميع منتج</h5>
                    <div class="col-12 mb-2">
                        <label>اسم جديد للمنتج فى الفاتورة</label>
                        <input id="gather-item-name" type="text" class="form-control">
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>السعر</th>
                                <th>الكمية</th>
                                <th>حذف</th>
                            </tr>
                        </thead>
                        <tbody id="table-body-gather">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">
                                    <button class="btn btn-sm btn-primary" id="add-gather-btn">اضافة</button>
                                </td>
                                <td colspan="2">
                                    الاجمالى
                                </td>
                                <td><span id="total_gather">0</span> جنية</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-6 my-4">
            <div class="card shadow">
                <div class="card-body">
                    <h5 class="card-title">الفاتورة</h5>
                    <div class="row mb-2">
                        <div class="col">
                            <label>اسم الموظف</label>
                            <select id="employee" class="form-control">
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->name }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label>تاريخ الفاتورة</label>
                            <input type="date" value="{{ date('Y-m-d') }}" id="date" name="date"
                                class="form-control">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>اسم العميل</label>
                            <input id="name" type="text" class="form-control">
                        </div>
                        <div class="col">
                            <label>رقم هاتف العميل</label>
                            <input type="text" id="phone" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col">
                            <label>خصم</label>
                            <input type="number" class="form-control" value="0" id="disc_val">
                        </div>
                        <div class="col">
                            <label>نوع الخصم</label>
                            <select id="disc_type_val" class="form-control">
                                <option value="ratio">نسبة مئوية</option>
                                <option value="amount">مبلغ مالى (جنية)</option>
                            </select>
                        </div>
                    </div>
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>السعر</th>
                                <th>الكمية</th>
                                <th>حذف</th>
                            </tr>
                        </thead>
                        <tbody id="table-body-invoice">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right">الاجمالى</td>
                                <td colspan="2" class="text-right"><span id="total">0</span> جنية</td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">الخصم</td>
                                <td colspan="2" class="text-right"><span id="td-disc">0</span> <span
                                        id="td-disc-type">%</span></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-right">السعر بعد الخصم</td>
                                <td colspan="2" class="text-right"><span id="total_after_discount">0</span> جنية</td>
                            </tr>
                            <tr>
                                <td colspan="2" class="text-right w-50">
                                    <button id="pay" class="btn btn btn-info w-100">دفع</button>
                                </td>
                                <td></td>
                                <td colspan="2" class="text-right w-50">
                                    <button id="pay_print" class="btn btn btn-warning w-100">دفع & طباعة</button>
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
                <h5>رقم الفاتورة : <span id="invoice_order_id"></span></h5>
                <h5>تاريخ الاصدار : <span id="invoice_order_date"></span></h5>
                <h5>اسم الموظف : <span id="invoice_employee"></span></h5>
                <h5>اسم العميل : <span id="invoice_client"></span></h5>
                <h5>رقم هاتف العميل : <span id="invoice_phone"></span></h5>
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

                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <th colspan="2">الاجمالى</th>
                            <th><span id="invoice-total"></span> جنية</th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <th colspan="2">الخصم</th>
                            <th id="invoice-disc"></th>
                        </tr>
                        <tr>
                            <td></td>
                            <td></td>
                            <th colspan="2">السعر بعد الخصم</th>
                            <th><span id="invoice-after-disc"></span> جنية</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </body>

        </html>
    </div>
@endsection

@section('script')

    <script src="{{ asset('js/search.js') }}"></script>

    <script>
        let total = 0;
        let total_gather = 0;
        let gather_id = 1;
        let gather_items = {};
        gather_items[gather_id] = {};
        let discount = 0;
        let discountType = "ratio";
        let price_after = 0;
        let last_qty = 1;
        let data_invoice = {};
        let invoice_items = {};

        function calDisc() {
            if (discountType == "ratio") {
                price_after = total - (total * (discount / 100));
            } else {
                price_after = total - discount;
            }
            $("#total_after_discount").text(price_after);
        }

        $("#disc_val").on("keyup", function() {
            discount = $(this).val();
            $("#td-disc").text(discount);
            calDisc();
        })

        $("#disc_type_val").on("change", function() {
            discountType = $(this).val();
            $("#td-disc-type").text(discountType == "amount" ? "جنية" : "%");
            calDisc();
        })

        $(document).on("click", ".add-item", function() {
            let id = $(this).data("id");
            let name = $(this).data("name");
            let price = $(this).data("price");

            if (data_invoice[id] || data_invoice[id] == 0) {
                total -= price * data_invoice[id];
                $("#total").text(total);
                let qty = data_invoice[id] + 1;
                total += price * qty;
                $("#total").text(total);
                calDisc();
                data_invoice[id] = qty;
                invoice_items[id] = {
                    code: id,
                    name: name,
                    price: price,
                    qty: qty
                };
                $("input[data-id='" + id + "']").val(qty);
                return;
            }

            data_invoice[id] = 1;

            invoice_items[id] = {
                code: id,
                name: name,
                price: price,
                qty: 1
            };

            total += parseInt(price);
            $("#total").text(total);

            calDisc();

            let row = `
                <tr>
                    <td>${id}</td>
                    <td>${name}</td>
                    <td>${price} جنية</td>
                    <td>
                        <input type="number" class="form-control qty" value="1" data-name="${name}" data-id="${id}" data-price="${price}">
                    </td>
                    <td><button data-price="${price}" data-id="${id}" class="btn btn-sm btn-danger del-item">حذف</button></td>
                </tr>
            `;

            $("#table-body-invoice").append(row);
        })

        $(document).on("keyup", ".qty", function() {
            let price = $(this).data("price");
            let id = $(this).data("id");
            let name = $(this).data("name");

            total -= price * last_qty;
            $("#total").text(total);
            let qty = $(this).val();
            qty = qty == "" ? 0 : qty;
            total += price * qty;
            last_qty = qty;
            $("#total").text(total);
            calDisc();

            if (data_invoice[id] || data_invoice[id] == 0) {
                data_invoice[id] = parseInt(qty);
            } else {
                qtyMaterial(id, qty);
            }

            if (name) {
                invoice_items[id] = {
                    code: id,
                    name: name,
                    price: price,
                    qty: parseInt(qty)
                };
            }
        })

        function qtyMaterial(id, qty) {
            for (const key in gather_items[id]) {
                var gather_price = gather_items[id][key].price;
                var gather_qty = gather_items[id][key].qty;

                data_invoice[key] = data_invoice[key] - gather_items[id][key].total;

                gather_items[id][key].total = qty * gather_qty;

                data_invoice[key] = data_invoice[key] + gather_items[id][key].total;
            }
        }

        $(document).on("focus", ".qty", function() {
            let qty = $(this).val();
            qty = qty == "" ? 0 : qty;
            last_qty = qty;
        })

        $(document).on("click", ".del-item", function() {
            let price = $(this).data("price");
            let id = $(this).data("id");

            if (data_invoice[id] || data_invoice[id] == 0) {
                deleteProduct(id, price);
            } else {
                deleteMaterial(id, price);
            }

            delete invoice_items[id];
            calDisc();
            $(this).closest("tr").remove();
        })

        function deleteProduct(id, price) {
            total -= parseInt(price) * data_invoice[id];
            $("#total").text(total);
            delete data_invoice[id];
        }

        function deleteMaterial(id, price) {
            total -= parseInt(price) * invoice_items[id].qty;
            $("#total").text(total);

            for (const key in gather_items[id]) {
                data_invoice[key] = data_invoice[key] - gather_items[id][key].total;
                if (data_invoice[key] == 0) {
                    delete data_invoice[key];
                }
            }

            delete gather_items[id];
        }

        $(document).on("click", ".gather-item", function() {
            let id = $(this).data("id");
            let name = $(this).data("name");
            let price = $(this).data("price");

            if (gather_items[gather_id][id]) {
                total_gather -= price * gather_items[gather_id][id].qty;
                $("#total_gather").text(total_gather);
                let qty = gather_items[gather_id][id].qty + 1;
                total_gather += price * qty;
                $("#total_gather").text(total_gather);

                gather_items[gather_id][id] = {
                    qty: qty,
                    price: price,
                    total: qty,
                    name: name
                };
                $("input[data-id='" + id + "']").val(qty);
                return;
            }

            gather_items[gather_id][id] = {
                qty: 1,
                price: price,
                total: 1,
                name: name,
            };

            total_gather += parseInt(price);
            $("#total_gather").text(total_gather);

            let row = `
                <tr>
                    <td>${id}</td>
                    <td>${name}</td>
                    <td>${price} جنية</td>
                    <td>
                        <input type="number" class="form-control qty-gather" value="1" data-id="${id}" data-price="${price}">
                    </td>
                    <td><button data-price="${price}" data-id="${id}" class="btn btn-sm btn-danger del-gather">حذف</button></td>
                </tr>
            `;

            $("#table-body-gather").append(row);
        })

        $(document).on("keyup", ".qty-gather", function() {
            let price = $(this).data("price");
            let id = $(this).data("id");

            total_gather -= price * last_qty;
            $("#total_gather").text(total_gather);
            let qty = $(this).val();
            qty = qty == "" ? 0 : qty;
            total_gather += price * qty;
            last_qty = qty;
            $("#total_gather").text(total_gather);

            gather_items[gather_id][id].qty = parseInt(qty);
            gather_items[gather_id][id].total = parseInt(qty);
        })

        $(document).on("focus", ".qty-gather", function() {
            let qty = $(this).val();
            qty = qty == "" ? 0 : qty;
            last_qty = qty;
        })

        $(document).on("click", ".del-gather", function() {
            let price = $(this).data("price");
            let id = $(this).data("id");

            total_gather -= parseInt(price) * gather_items[gather_id][id].qty;
            $("#total_gather").text(total_gather);

            delete gather_items[gather_id][id];
            $(this).closest("tr").remove();
        })

        $("#add-gather-btn").click(function() {
            let name = $("#gather-item-name").val();

            if (name == "") {
                alert("ادخل اسم جديد للمنتج الذى تم تجميعه");
                return;
            }

            if (total_gather == 0) {
                alert("ادخل منتجات اولا");
                return;
            };

            invoice_items[gather_id] = {
                code: gather_id,
                name: name,
                price: total_gather,
                qty: 1
            };

            for (const key in gather_items[gather_id]) {
                if (data_invoice[key]) {
                    data_invoice[key] += gather_items[gather_id][key].qty;
                } else {
                    data_invoice[key] = gather_items[gather_id][key].qty;
                }
            }

            let row = `
                <tr>
                    <td>${gather_id}</td>
                    <td>${name}</td>
                    <td>${total_gather} جنية</td>
                    <td>
                        <input type="number" class="form-control qty" value="1" data-name="${name}" data-id="${gather_id}" data-price="${total_gather}">
                    </td>
                    <td><button data-price="${total_gather}" data-id="${gather_id}" class="btn btn-sm btn-danger del-item">حذف</button></td>
                </tr>
            `;

            $("#table-body-invoice").append(row);
            gather_id += 1;
            gather_items[gather_id] = {};
            total += total_gather;
            $("#total").text(total);
            calDisc();
            total_gather = 0;
            $("#total_gather").text(total_gather);
            $("#table-body-gather").html("");
            $("#gather-item-name").val("");
        })

        $("#pay").click(function() {
            pay();
        });

        $("#pay_print").click(function() {
            pay(true);
        })

        function pay(print = false) {
            let data = {
                discount: discount,
                discount_type: discountType,
                data_invoice: data_invoice,
                invoice_items: invoice_items,
                gather_items: gather_items,
                client_name: $("#name").val(),
                phone: $("#phone").val(),
                employee: $("#employee").val(),
                type: "offline",
                status: "finished",
                created_at: $("#date").val(),
            }

            $.ajax({
                url: "{{ route('pay.store') }}",
                method: "GET",
                data: data,
                success: function(data) {
                    $("#div-errors").html(`<div class="alert alert-success alert-dismissible fade show" role="alert">
                        تم تسجيل الفاتورة بنجاح
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>`);

                    $("#table-body-invoice").html("");
                    $("#name").val("");
                    $("#date").val("{{ date('Y-m-d') }}");
                    $("#phone").val("");
                    $("#total").text(0);
                    $("#disc_val").val(0);
                    $("#total_after_discount").text(0);
                    $("#td-disc").text(0);

                    total = 0;
                    total_gather = 0;
                    gather_id = 1;
                    gather_items = {};
                    gather_items[gather_id] = {};
                    discount = 0;
                    price_after = 0;
                    last_qty = 1;
                    data_invoice = {};
                    invoice_items = {};

                    $("html, body").animate({
                        scrollTop: 0
                    }, 100);

                    if (print) {
                        let items = data.items;
                        let order = data.data;
                        let rows = "";
                        let i = 1;

                        for (const key in items) {
                            rows += `
                                <tr>
                                    <td>${i}</td>
                                    <td>${items[key].name}</td>
                                    <td>${items[key].price} جنية</td>
                                    <td>${items[key].qty}</td>
                                    <td>${items[key].price * items[key].qty} جنية</td>
                                </tr>
                            `;
                            i++;
                        }

                        $("#invoice-body").html(rows);
                        $("#invoice_order_id").text(order.id);
                        $("#invoice_order_date").text(formatDate(order.created_at));
                        $("#invoice_employee").text(order.employee);
                        $("#invoice_client").text(order.client_name);
                        $("#invoice_phone").text(order.phone);
                        $("#invoice-total").text(order.price);
                        $("#invoice-disc").text(order.discount + " " + (order.discount_type == "amount" ?
                            "جنية" : "%"));
                        $("#invoice-after-disc").text(order.total_price);

                        printInvoice("printableDiv");
                    }
                },
                error: function(data) {
                    $("html, body").animate({
                        scrollTop: 0
                    }, 100);

                    let errors = data.responseJSON.errors;
                    $("#div-errors").html("");

                    if (!errors && data.responseJSON.exception) {
                        $("#div-errors").append(
                            `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                لقد حدث خطأ ما برجاء الاتصال بالدعم الفنى على الرقم 01144435326 .
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>`
                        );
                        return;
                    }

                    if (errors["data_invoice"] || errors["invoice_items"]) {
                        $("#div-errors").append(
                            `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                لا يمكن دفع فاتورة فارغة
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>`
                        );
                    }

                    if (errors['discount']) {
                        $("#div-errors").append(
                            `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                الخصم يجب ان يكون بين 0 و 100
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>`
                        );
                    }

                    if (data.responseJSON.status) {
                        for (const key in errors) {
                            $("#div-errors").append(
                                `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${errors[key]}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>`
                            );
                        }
                    }
                }
            });
        }

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

        function formatDate(date) {
            const options = {
                year: 'numeric',
                month: '2-digit',
                day: '2-digit',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true // to display time in AM/PM format
            };
            date = new Date(date);
            return date.toLocaleString('en-US', options).replace(/\//g, '-');
        }
    </script>
@endsection
