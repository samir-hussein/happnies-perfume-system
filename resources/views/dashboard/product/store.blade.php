@extends('dashboard.layouts.main-layout')

@section('title', 'اضافة منتج جديد')

@section('content')
    @if (session('success'))
        <div class="alert alert-success" role="alert">{{ session('success') }}</div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
    @endif

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center my-3">
                    <div class="col">
                        <h2 class="page-title">إضافة منتج جديد</h2>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('dashboard.product.index') }}" class="btn btn-dark"><span
                                class="fe fe-arrow-right fe-16 mr-3"></span>العودة</a>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header">
                        <strong class="card-title">إضافة منتج</strong>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('dashboard.product.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="name">الاسم</label>
                                <input type="text" class="form-control" name="name" dir="auto"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">الكود</label>
                                <input type="text" class="form-control" name="code" dir="auto"
                                    value="{{ old('code') }}">
                                @error('code')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">الوصف</label>
                                <textarea type="text" class="form-control" name="description" dir="auto">{{ old('description') }}</textarea>
                                @error('description')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <label for="name">الكمية</label>
                                    <input type="text" class="form-control" id="qty" name="qty" dir="auto"
                                        value="{{ old('qty') }}" placeholder="0">
                                    @error('qty')
                                        <p style="color: red">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="name">وحدة القياس</label>
                                    <input type="text" class="form-control" id="unit" name="unit" dir="auto"
                                        value="{{ old('unit') }}">
                                    @error('unit')
                                        <p style="color: red">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="name">حدد كمية لارسال تحذير بالانتهاء</label>
                                    <input type="text" class="form-control" id="warning_qty" name="warning_qty"
                                        dir="auto" value="{{ old('warning_qty') }}" placeholder="0">
                                    @error('warning_qty')
                                        <p style="color: red">* {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <label for="name">سعر القطعة (جنية)</label>
                                    <input type="text" class="form-control" id="unit_price" name="unit_price"
                                        dir="auto" value="{{ old('unit_price') }}" placeholder="0">
                                    @error('unit_price')
                                        <p style="color: red">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="name">السعر الاجمالى (جنية)</label>
                                    <input type="text" class="form-control" id="unit_price_total" dir="auto"
                                        placeholder="0">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <label for="name">سعر البيع (جنية)</label>
                                    <input type="text" class="form-control" id="price" name="price" dir="auto"
                                        value="{{ old('price') }}" placeholder="0">
                                    @error('price')
                                        <p style="color: red">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="name">السعر الاجمالى (جنية)</label>
                                    <input type="text" class="form-control" id="price_total" dir="auto"
                                        placeholder="0">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <label for="discount">خصم</label>
                                    <input type="text" class="form-control" id="discount" name="discount"
                                        dir="auto" value="{{ old('discount') }}" placeholder="0">
                                    @error('discount')
                                        <p style="color: red">* {{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col">
                                    <label for="discount_type">نوع الخصم</label>
                                    <select class="form-control" id="discount_type" name="discount_type">
                                        <option {{ 'ratio' == old('discount_type') ? 'selected' : '' }} value="ratio">
                                            نسبة
                                            مئوية</option>
                                        <option {{ 'amount' == old('discount_type') ? 'selected' : '' }} value="amount">
                                            مبلغ
                                            مالي (جنية)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col">
                                    <label for="discount_price">سعر البيع بعد الخصم</label>
                                    <input disabled class="form-control" id="discount_price" dir="auto"
                                        placeholder="0">
                                </div>
                                <div class="col">
                                    <label for="discount_price_total">السعر الاجمالى</label>
                                    <input disabled class="form-control" id="discount_price_total" dir="auto"
                                        placeholder="0">
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="name">القسم</label>
                                <select class="select-sub form-control" name="category_id">
                                    @foreach ($categories as $category)
                                        <option {{ $category->id == old('category_id') ? 'selected' : '' }}
                                            value="{{ $category->id }}">
                                            {{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">إضافة</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $('#qty').keyup(function() {
            var qty = $('#qty').val();
            var unit_price = $('#unit_price').val();
            var price = $('#price').val();
            var unit_price_total = qty * unit_price;
            var price_total = price * qty;
            $('#unit_price_total').val(unit_price_total);
            $('#price_total').val(price_total);
            priceAfterDiscount(price);
        });

        $('#price').keyup(function() {
            var price = $('#price').val();
            var qty = $('#qty').val();
            var price_total = price * qty;
            $('#price_total').val(price_total);
            priceAfterDiscount(price);
        });

        $('#price_total').keyup(function() {
            var price_total = $('#price_total').val();
            var qty = $('#qty').val();
            var price = price_total / qty;
            $('#price').val(price);
            priceAfterDiscount(price);
        });

        $('#unit_price').keyup(function() {
            var qty = $('#qty').val();
            var unit_price = $('#unit_price').val();
            var unit_price_total = qty * unit_price;
            $('#unit_price_total').val(unit_price_total);
        });

        $('#unit_price_total').keyup(function() {
            var qty = $('#qty').val();
            var unit_price_total = $('#unit_price_total').val();
            var unit_price = unit_price_total / qty;
            $('#unit_price').val(unit_price);
        });

        $('#discount').keyup(function() {
            var price = $('#price').val();
            priceAfterDiscount(price);
        });

        $('#discount_type').change(function() {
            var price = $('#price').val();
            priceAfterDiscount(price);
        });

        function priceAfterDiscount(price) {
            var discount = $('#discount').val();
            var discount_type = $('#discount_type').val();

            if (discount_type == 'ratio') {
                var discount_price = price * (discount / 100);
            } else {
                var discount_price = discount;
            }

            var qty = $('#qty').val();
            var price_after_discount = price - discount_price;
            var discount_price_total = price_after_discount * qty;

            $('#discount_price').val(price_after_discount + " جنية");
            $('#discount_price_total').val(discount_price_total + " جنية");
        }

        function atLoad() {
            var qty = $('#qty').val();
            var price = $('#price').val();
            var unit_price = $('#unit_price').val();
            var unit_price_total = qty * unit_price;
            var price_total = price * qty;
            $('#unit_price_total').val(unit_price_total);
            $('#price_total').val(price_total);
            priceAfterDiscount(price);
        }

        atLoad();
    </script>
@endsection
