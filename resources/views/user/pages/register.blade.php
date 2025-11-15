@extends('layouts.client')

@section('title', 'Đăng ký')

@section('breadcrumb', 'Đăng ký')

@section('content')

    <div class="ltn__login-area pb-110">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area text-center">
                        <h1 class="section-title">ĐĂNG KÝ TÀI KHOẢN</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="account-login-inner">
                        <form action="{{ route('register') }}" class="ltn__form-box contact-form-box" method="POST" id="register-form">
                            @csrf  <!-- Giữ nguyên, bắt buộc cho CSRF protection trong Laravel -->

                            <input type="text" name="name" placeholder="Họ và tên" value="{{ old('name') }}" required>
                            @error('name')  <!-- Giữ nguyên, hiển thị lỗi nếu validation fail (từ controller) -->
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <input type="email" name="email" placeholder="Email*" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <input type="password" name="password" placeholder="Mật khẩu*" required>
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <input type="password" name="password_confirmation" placeholder="Xác nhận mật khẩu*" required>
                            @error('password_confirmation')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <div class="btn-wrapper">
                                <button class="theme-btn-1 btn reverse-color btn-block" type="submit">TẠO TÀI KHOẢN</button>
                            </div>
                        </form>
                        <div class="by-agree text-center">
                            <p>Bằng cách tạo tài khoản, bạn đồng ý với:</p>
                            <p><a href="#">CÁC ĐIỀU KHOẢN &nbsp; &nbsp; | &nbsp; &nbsp; CHÍNH SÁCH BẢO MẬT</a></p>
                            <div class="go-to-btn mt-50">
                                <a href="{{ route('login') }}">ĐÃ CÓ TÀI KHOẢN ?</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
