@extends('dashboard.layouts.main-layout')

@section('title', 'البيانات الشخصية')

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <h2 class="h3 mb-4 page-title">البيانات الشخصية</h2>
                <div class="my-4">

                    <form action="{{ route('dashboard.profile.update') }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="row mt-5 align-items-center">
                            <div class="col-md-3 text-center mb-5">
                                <div class="avatar avatar-xl">
                                    <img src="{{ asset('images/teacher.png') }}" alt="..."
                                        class="avatar-img rounded-circle">
                                </div>
                            </div>
                            <div class="col">
                                <div class="row align-items-center">
                                    <div class="col-md-7">
                                        <h4 class="mb-1">{{ auth()->user()->name }}</h4>
                                        <p class="small mb-3"><span class="badge badge-dark">EGYPT</span></p>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-7">
                                        <p class="text-muted">{{ auth()->user()->email }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="my-4">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                        @endif

                        <div class="form-group">
                            <label for="name">الاسم</label>
                            <input type="text" class="form-control" name="name" id="name"
                                value="{{ auth()->user()->name }}" dir="auto">
                            @error('name')
                                <p style="color: red">* {{ $message }}</p>
                            @enderror
                        </div>

                        <hr class="my-4">
                        <div class="mb-4">
                            <div>
                                <div class="form-group">
                                    <label for="inputPassword4">كلمة المرور الحالية</label>
                                    <input dir="auto" name="old_password" type="password" class="form-control"
                                        id="inputPassword5">
                                    @error('old_password')
                                        <p style="color: red">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword5">كلمة المرور الجديدة</label>
                                    <input dir="auto" name="password" type="password" class="form-control"
                                        id="inputPassword5">
                                    @error('password')
                                        <p style="color: red">* {{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="inputPassword6">تأكيد كلمة المرور الجديدة</label>
                                    <input dir="auto" name="password_confirmation" type="password" class="form-control"
                                        id="inputPassword6">
                                </div>
                            </div>

                        </div>
                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    </form>
                </div> <!-- /.card-body -->
            </div> <!-- /.col-12 -->
        </div> <!-- .row -->
    </div> <!-- .container-fluid -->
@endsection
