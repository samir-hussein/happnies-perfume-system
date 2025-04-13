@extends('layouts.auth-layout')

@section('title', 'إنشاء حساب')

@section('content')
    <form class="col-lg-6 col-md-8 col-10 mx-auto" action="{{ route('register') }}" method="POST">
        @csrf
        <input type="hidden" name="role" value="admin">
        <div class="mx-auto text-center my-4">
            <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="/">
                <img src="{{ asset('images/logo.png') }}" alt="logo" width="100">
            </a>
            <h2 class="my-3">إنشاء حساب</h2>

            @if (session('success'))
                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
            @endif

        </div>
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
                    <input dir="auto" type="password" class="form-control" name="password" id="inputPassword5">
                    @error('password')
                        <p style="color: red">* {{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="inputPassword6">تأكيد كلمة المرور</label>
                    <input dir="auto" type="password" class="form-control" name="password_confirmation"
                        id="inputPassword6">
                </div>
            </div>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">إنشاء حساب</button>

        <p class="mt-5 mb-3 text-muted text-center" dir="ltr">2024 © <a href="https://www.facebook.com/samirHussein011"
                target="_blank">Samir Hussein</a></p>
    </form>

@endsection
