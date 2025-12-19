@extends('layouts.client')

@section('title', 'Giỏ hàng')
@section('breadcrumb', 'Giỏ hàng')

@section('content')

    <div class="liton__shoping-cart-area mb-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shoping-cart-inner">
                        <div class="shoping-cart-table table-responsive">
                            <table class="table">
                                <tbody>
                                    @php
                                        $cartTotal = 0;
                                        $hasError = false; // Biến cờ để kiểm tra lỗi
                                    @endphp

                                    @forelse ($cartItems as $item)
                                        @php
                                            $subtotal = $item['price'] * $item['quantity'];
                                            $cartTotal += $subtotal;

                                            // Kiểm tra lỗi cho từng sản phẩm
                                            // Lấy thông tin sản phẩm mới nhất từ DB (vì $item có thể là session cũ)
                                            $product = \App\Models\Product::find($item['product_id']);
                                            $isOutOfStock = false;
                                            $isNotEnoughStock = false;

                                            if ($product) {
                                                if ($product->status == 'out_of_stock') {
                                                    $isOutOfStock = true;
                                                    $hasError = true;
                                                } elseif ($product->stock < $item['quantity']) {
                                                    $isNotEnoughStock = true;
                                                    $hasError = true;
                                                }
                                            } else {
                                                // Sản phẩm bị xóa hoàn toàn khỏi DB
                                                $isOutOfStock = true;
                                                $hasError = true;
                                            }
                                        @endphp

                                        <tr class="{{ $isOutOfStock || $isNotEnoughStock ? 'cart-item-error' : '' }}"
                                            style="{{ $isOutOfStock || $isNotEnoughStock ? 'background-color: #fff0f0;' : '' }}">

                                            <td class="cart-product-remove">
                                                <button class="remove-from-cart"
                                                    data-id="{{ $item['product_id'] }}">x</button>
                                            </td>

                                            <td class="cart-product-image">
                                                <a href="javascript:void(0)">
                                                    <img src="{{ asset('storage/' . ($item['image'] ?? 'uploads/products/default-product.png')) }}"
                                                        alt="Sản phẩm">
                                                </a>
                                            </td>

                                            <td class="cart-product-info">
                                                <h4><a href="javascript:void(0)">{{ $item['name'] }}</a></h4>

                                                {{-- HIỂN THỊ CẢNH BÁO LỖI --}}
                                                @if ($isOutOfStock)
                                                    <p
                                                        style="color: red; font-weight: bold; font-size: 13px; margin-bottom: 0;">
                                                        <i class="fas fa-exclamation-circle"></i> Sản phẩm đã ngưng kinh
                                                        doanh
                                                    </p>
                                                @elseif($isNotEnoughStock)
                                                    <p
                                                        style="color: orange; font-weight: bold; font-size: 13px; margin-bottom: 0;">
                                                        <i class="fas fa-exclamation-triangle"></i> Kho chỉ còn
                                                        {{ $product->stock }} sản phẩm
                                                    </p>
                                                @endif
                                            </td>

                                            <td class="cart-product-price">{{ number_format($item['price'], 0, ',', '.') }}đ
                                            </td>

                                            <td class="cart-product-quantity">
                                                <div class="cart-plus-minus">
                                                    <div class="dec qtybutton">-</div>
                                                    <input type="text" value="{{ $item['quantity'] }}" name="qtybutton"
                                                        class="cart-plus-minus-box" readonly data-max="{{ $item['stock'] }}"
                                                        data-id="{{ $item['product_id'] }}">
                                                    <div class="inc qtybutton">+</div>
                                                </div>
                                            </td>

                                            <td class="cart-product-subtotal">{{ number_format($subtotal, 0, ',', '.') }}đ
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">Giỏ hàng của bạn đang trống !</td>
                                        </tr>

                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if (!empty($cartItems) && count($cartItems) > 0)
                            <div class="shoping-cart-total mt-50">
                                <h4>Tổng Giỏ Hàng</h4>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Tổng Tiền Hàng</td>
                                            <td><span
                                                    class="cart-total">{{ number_format($cartTotal, 0, ',', '.') }}VNĐ</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Phí Vận Chuyển</td>
                                            <td>15.000VND</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Tổng Cộng</strong></td>
                                            <td><strong><span
                                                        class="cart-grand-total">{{ number_format($cartTotal + 15000, 0, ',', '.') }}VNĐ</span></strong>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="btn-wrapper text-right text-end">
                                    {{-- LOGIC KHÓA NÚT THANH TOÁN --}}
                                    @if ($hasError)
                                        <button class="theme-btn-1 btn btn-effect-1" disabled
                                            style="background-color: #ccc; cursor: not-allowed; border-color: #ccc;">
                                            Vui lòng xóa sản phẩm lỗi để thanh toán
                                        </button>
                                    @else
                                        <a href="{{ route('checkout') }}" class="theme-btn-1 btn btn-effect-1">Tiến hành
                                            thanh toán</a>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
