@extends('dashboard.layouts.main-layout')

@section('title', 'اضافة مستخدم جديد')

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
                        <h2 class="page-title">إضافة مستخدم جديد</h2>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('dashboard.user.index') }}" class="btn btn-dark"><span
                                class="fe fe-arrow-right fe-16 mr-3"></span>العودة</a>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header">
                        <strong class="card-title">إضافة مستخدم</strong>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('dashboard.user.store') }}">
                            @csrf
                            <input type="hidden" name="role" value="admin">
                            <div class="form-group">
                                <label for="firstname">الأسم</label>
                                <input dir="auto" type="text" id="firstname" name="name" class="form-control"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="inputEmail4">البريد الإلكترونى</label>
                                <input dir="auto" type="email" class="form-control" name="email" id="inputEmail4"
                                    value="{{ old('email') }}">
                                @error('email')
                                    <p style="color: red">* {{ $message }}</p>
                                @enderror
                            </div>
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="inputPassword5">كلمة المرور</label>
                                        <input dir="auto" type="password" class="form-control" name="password"
                                            id="inputPassword5">
                                        @error('password')
                                            <p style="color: red">* {{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword6">تأكيد كلمة المرور</label>
                                        <input dir="auto" type="password" class="form-control"
                                            name="password_confirmation" id="inputPassword6">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">إضافة</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
