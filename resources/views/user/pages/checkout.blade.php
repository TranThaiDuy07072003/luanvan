@extends('layouts.client')

@section('title', 'Đặt hàng')

@section('breadcrumb', 'Đặt hàng')

@section('content')


    <div class="ltn__checkout-area mb-105">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ltn__checkout-inner">

                        <div class="ltn__checkout-single-content mt-50">
                            <h4 class="title-2">Chi tiết đặt hàng</h4>

                            <div class="select-address">
                                <div>
                                    <h6>Chọn địa chỉ khác</h6>
                                </div>

                                <div>
                                    <select name="address_id" id="list_address" class="input-item">
                                        @foreach ($addresses as $address)
                                            <option value="{{ $address->id }}" {{ $address->default ? 'selected' : '' }}>
                                                {{ $address->full_name }} - {{ $address->address }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <a href="{{ route('account') }}" class="btn theme-btn-1 btn-effect-1 text-uppercase">Thêm địa chỉ mới</a>
                                </div>

                            </div>

                            <div class="ltn__checkout-single-content-info">

                                <h6>Thông tin cá nhân</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="input-item input-item-name ltn__custom-icon">
                                            <input type="text" name="ltn__name" placeholder="Họ và tên" value="{{ $defaultAddress->full_name }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="input-item input-item-phone ltn__custom-icon">
                                            <input type="text" name="ltn__lastname" placeholder="Số điện thoại" value="{{ $defaultAddress->phone }}" readonly>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-lg-6 col-md-6">
                                        <h6>Địa chỉ</h6>
                                        <div class="input-item">
                                            <input type="text" placeholder="Số nhà và tên đường" value="{{ $defaultAddress->address }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <h6>Thành phố</h6>
                                        <div class="input-item">
                                            <input type="text" placeholder="Thành phố" value="{{ $defaultAddress->city }}" readonly>
                                        </div>
                                    </div>

                                </div>




                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="ltn__checkout-payment-method mt-50">
                        <h4 class="title-2">Phương thức thanh toán</h4>
                        <form action="" method="POST">
                            @csrf
                            <div id="checkout_payment">

                                <div class="card">

                                    <h5 class="ltn__card-title">
                                        <input type="radio" name="payment_method" value="cash" id="payment_cod" checked>
                                        <label for="payment_cod">
                                            Thanh toán khi giao<img src="{{ asset('assets/user/img/icons/cash.png') }}"
                                                alt="javascript:void(0)">
                                        </label>
                                    </h5>

                                </div>

                                <div class="card">

                                    <h5 class="collapsed ltn__card-title">
                                        <input type="radio" name="payment_method" value="zalopay" id="payment_zalopay"
                                            checked>
                                        <label for="payment_zalopay">
                                            Zalopay <img src="{{ asset('assets/user/img/icons/payment-3.png') }}"
                                                alt="javascript:void(0)">
                                        </label>
                                    </h5>

                                </div>
                            </div>
                            <div class="ltn__payment-note mt-30 mb-30">
                                <p>XIN QUÝ KHÁCH VUI LÒNG KIỂM TRA LẠI THÔNG TIN, SỐ SẢN PHẨM MUA , ĐỊA CHỈ HOẶC SỐ ĐIỆN
                                    THOẠI ĐỂ TRÁNH NHẦM LẪN .</p>
                            </div>
                            <button class="btn theme-btn-1 btn-effect-1 text-uppercase" type="submit">Đặt hàng</button>
                        </form>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="shoping-cart-total mt-50">
                        <h4 class="title-2">Tổng giỏ hàng</h4>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Nấm hương <strong>× 2</strong></td>
                                    <td>$298.00</td>
                                </tr>

                                <tr>
                                    <td>Phí vận chuyển</td>
                                    <td>15.000đ</td>
                                </tr>

                                <tr>
                                    <td><strong>Tổng cộng</strong></td>
                                    <td><strong>$633.00</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
