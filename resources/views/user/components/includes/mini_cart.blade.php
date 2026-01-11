<div class="ltn__utilize-menu-head">
    <span class="ltn__utilize-menu-title">Giỏ hàng</span>
    <button class="ltn__utilize-close">×</button>
</div>


@php
    $subtotal = 0;
@endphp

<div class="mini-cart-product-area ltn__scrollbar">
    @if (!empty($cartItems) && count($cartItems) > 0)

        @foreach ($cartItems as $item)
            @php
                // Lấy thông tin sản phẩm
                $product = auth()->check() ? $item->product : \App\Models\Product::find($item['product_id']);

                // Kiểm tra nếu sản phẩm bị xóa khỏi DB thì bỏ qua vòng lặp này
                if (!$product) {
                    continue;
                }

                $quantity = auth()->check() ? $item->quantity : $item['quantity'];
                $subtotal += $quantity * $product->price;

                // Xử lý ảnh an toàn (tránh lỗi nếu không có ảnh)
                $firstImage = $product->images->first();
                $imagePath = $firstImage
                    ? asset('storage/' . $firstImage->image)
                    : asset('storage/uploads/products/default-product.png');
            @endphp

            <div class="mini-cart-item clearfix" id="mini-cart-item-{{ $product->id }}">
                <div class="mini-cart-img">
                    <a href="{{ route('product.detail', $product->slug) }}">
                        <img src="{{ $imagePath }}" alt="{{ $product->name }}">
                    </a>

                    {{-- Thêm class delete để JS bắt sự kiện --}}
                    <span class="mini-cart-item-delete" data-id="{{ $product->id }}">
                        <i class="icon-cancel"></i>
                    </span>
                </div>

                <div class="mini-cart-info">
                    <h6><a href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a></h6>
                    <span class="mini-cart-quantity">{{ $quantity }} x
                        {{ number_format($product->price, 0, ',', '.') }}đ</span>

                    {{-- Cảnh báo hết hàng --}}
                    @if ($product->status == 'out_of_stock')
                        <br><span style="color: red; font-size: 11px; font-weight:bold;">(Hết hàng)</span>
                    @elseif($product->stock < $quantity)
                        <br><span style="color: orange; font-size: 11px; font-weight:bold;">(Không đủ hàng)</span>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        {{-- 2. Giao diện khi giỏ hàng trống --}}
        <div class="empty-cart-text text-center" style="padding: 20px;">
            <p>Giỏ hàng của bạn đang trống.</p>
            <a href="{{ route('products.index') }}" class="theme-btn-1 btn btn-effect-1 btn-sm">Mua sắm ngay</a>
        </div>
    @endif
</div>

{{-- 3. Chỉ hiện chân trang (Tổng tiền & Nút) khi có hàng --}}
@if (!empty($cartItems) && count($cartItems) > 0)
    <div class="mini-cart-footer">
        <div class="mini-cart-sub-total">
            <h5>Tổng tiền: <span>{{ number_format($subtotal, 0, ',', '.') }} VNĐ</span></h5>
        </div>
        <div class="btn-wrapper">
            <a href="{{ route('cart.index') }}" class="theme-btn-1 btn">Xem giỏ hàng</a>
            <a href="{{ route('checkout') }}" class="theme-btn-2 btn">Thanh toán</a>
        </div>
    </div>
@endif
