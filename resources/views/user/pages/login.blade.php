@extends('layouts.client')

@section('title', 'Đăng nhập')

@section('breadcrumb', 'Đăng nhập')

@section('content')

<!-- LOGIN AREA START -->
        <div class="ltn__login-area pb-65">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-title-area text-center">
                            <h1 class="section-title">Đăng Nhập <br>Vào Tài Khoản Của Bạn</h1>
                            <p>Chúng tôi mang đến những sản phẩm nông sản sạch, an toàn và chất lượng. Đăng nhập để trải nghiệm mua sắm thuận tiện và cá nhân hóa.</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="account-login-inner">
                            <form action="{{ route('login') }}" class="ltn__form-box contact-form-box" method="POST" id="login-form">
                                @csrf
                                <input type="text" name="email" placeholder="Email*" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <input type="password" name="password" placeholder="Mật khẩu*" required>
                                @error('password')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror

                                <div class="btn-wrapper mt-0">
                                    <button class="theme-btn-1 btn btn-block" type="submit">ĐĂNG NHẬP</button>
                                </div>
                                <div class="go-to-btn mt-20">
                                    <a href="{{ route('password.request') }}"><small>QUÊN MẬT KHẨU ?</small></a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="account-create text-center pt-50">
                            <h4>BẠN CHƯA CÓ TÀI KHOẢN ?</h4>
                            <p>Hãy đăng ký để có thể đặt hàng, nhận đề xuất cá nhân hóa, thanh toán nhanh hơn và dễ dàng theo dõi đơn hàng của bạn.</p>
                            <div class="btn-wrapper">
                                <a href="{{ route('register') }}" class="theme-btn-1 btn black-btn">ĐĂNG KÝ TÀI KHOẢN</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- LOGIN AREA END -->
        {{-- <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title-area text-center">
                        <h1 class="section-title">ĐĂNG NHẬP TÀI KHOẢN</h1>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6 offset-lg-3">
                    <div class="account-login-inner">
                        <form action="{{ route('login') }}" class="ltn__form-box contact-form-box" method="POST" id="register-form">
                            @csrf  <!-- Giữ nguyên, bắt buộc cho CSRF protection trong Laravel -->



                            <input type="email" name="email" placeholder="Email*" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror

                            <input type="password" name="password" placeholder="Mật khẩu*" required>
                            @error('password')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror



                            <div class="btn-wrapper">
                                <button class="theme-btn-1 btn reverse-color btn-block" type="submit">Đăng nhập</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div> --}}
    </div>


@endsection
