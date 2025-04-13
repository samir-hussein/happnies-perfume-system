@extends('dashboard.layouts.main-layout')

@section('style')
    <link rel="stylesheet" href="{{ asset('dashboard/css/dataTables.bootstrap4.css') }}">
@endsection

@section('title', 'الاقسام')

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

    @error('type')
        <div class="alert alert-danger" role="alert">{{ $message }}</div>
    @enderror

    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="row align-items-center my-3">
                    <div class="col">
                        <h2 class="page-title">اضافة قسم</h2>
                    </div>
                </div>
                <form action="{{ route('dashboard.category.store') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="name" class="form-control" placeholder="اسم القسم">
                        <select name="type" class="form-control" id="">
                            <option value="product">منتج</option>
                            <option value="material">خامات</option>
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">اضافة</button>
                        </div>
                    </div>
                </form>
                <div class="row align-items-center my-3">
                    <div class="col">
                        <h2 class="page-title">الاقسام</h2>
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
                                            <th>النوع</th>
                                            <th>عدد المنتجات</th>
                                            <th>حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td>
                                                    <span>{{ $category->name }}</span>
                                                    <div class="card-body">
                                                        <form id="category_{{ $category->id }}" class="form-inline"
                                                            method="POST"
                                                            action="{{ route('dashboard.category.update', ['category' => $category->id]) }}">
                                                            @csrf
                                                            @method('put')
                                                            <input name="name" type="text"
                                                                class="form-control mb-2 mr-sm-2" placeholder="اسم المجموعة"
                                                                value="{{ $category->name }}">
                                                            <button for="category_{{ $category->id }}" type="submit"
                                                                class="btn btn-sm btn-warning mb-2">تعديل</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="card-body">
                                                        <form id="category_type_{{ $category->id }}" class="form-inline"
                                                            method="POST"
                                                            action="{{ route('dashboard.category.update', ['category' => $category->id]) }}">
                                                            @csrf
                                                            @method('put')
                                                            <select name="type" class="form-control" id="">
                                                                <option
                                                                    {{ $category->type == 'product' ? 'selected' : '' }}
                                                                    value="product">منتج</option>
                                                                <option
                                                                    {{ $category->type == 'material' ? 'selected' : '' }}
                                                                    value="material">خامات</option>
                                                            </select>
                                                            <button for="category_type_{{ $category->id }}" type="submit"
                                                                class="btn btn-sm btn-warning mb-2">تعديل</button>
                                                        </form>
                                                    </div>
                                                </td>
                                                <td>{{ $category->products->count('id') }}</td>
                                                <td>
                                                    <form method="post"
                                                        action="{{ route('dashboard.category.destroy', ['category' => $category->id]) }}">
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
