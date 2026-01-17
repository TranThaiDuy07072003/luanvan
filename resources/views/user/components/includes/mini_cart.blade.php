<div class="ltn__utilize-menu-head">
    <span class="ltn__utilize-menu-title">Giỏ hàng</span>
    <button class="ltn__utilize-close">×</button>
</div>

@php
    $subtotal = 0;
    // Khởi tạo biến chặn thanh toán
    $blockCheckout = false;
@endphp

<div class="mini-cart-product-area ltn__scrollbar">
    @if (!empty($cartItems) && count($cartItems) > 0)

        @foreach ($cartItems as $item)
            @php
                $product = auth()->check() ? $item->product : \App\Models\Product::find($item['product_id']);

                if (!$product) { continue; }

                $quantity = auth()->check() ? $item->quantity : $item['quantity'];
                $subtotal += $quantity * $product->price;

                $firstImage = $product->images->first();
                $imagePath = $firstImage ? asset('storage/' . $firstImage->image) : asset('storage/uploads/products/default-product.png');

                // 1. Tính toán Hết hạn (Tính ngầm)
                $isExpired = false;
                if($product->expiry_date) {
                    $isExpired = \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($product->expiry_date));
                }

                // 2. Cập nhật biến chặn nếu gặp lỗi (Hết hàng OR Thiếu kho OR Hết hạn)
                if ($product->status == 'out_of_stock' || $product->stock < $quantity || $isExpired) {
                    $blockCheckout = true;
                }
            @endphp

            <div class="mini-cart-item clearfix" id="mini-cart-item-{{ $product->id }}">
                <div class="mini-cart-img">
                    <a href="{{ route('product.detail', $product->slug) }}">
                        <img src="{{ $imagePath }}" alt="{{ $product->name }}">
                    </a>
                    <span class="mini-cart-item-delete" data-id="{{ $product->id }}">
                        <i class="icon-cancel"></i>
                    </span>
                </div>

                <div class="mini-cart-info">
                    <h6><a href="{{ route('product.detail', $product->slug) }}">{{ $product->name }}</a></h6>
                    <span class="mini-cart-quantity">{{ $quantity }} x {{ number_format($product->price, 0, ',', '.') }}đ</span>

                    {{-- [SỬA ĐỔI] Gộp chung điều kiện: Hết kho HOẶC Hết hạn đều hiện chữ "Hết hàng" --}}
                    @if ($product->status == 'out_of_stock' || $isExpired)
                        <br><span style="color: red; font-size: 11px; font-weight:bold;">(Hết hàng)</span>

                    @elseif($product->stock < $quantity)
                        <br><span style="color: orange; font-size: 11px; font-weight:bold;">(Không đủ hàng)</span>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="empty-cart-text text-center" style="padding: 20px;">
            <p>Giỏ hàng của bạn đang trống.</p>
            <a href="{{ route('products.index') }}" class="theme-btn-1 btn btn-effect-1 btn-sm">Mua sắm ngay</a>
        </div>
    @endif
</div>

@if (!empty($cartItems) && count($cartItems) > 0)
    <div class="mini-cart-footer">
        <div class="mini-cart-sub-total">
            <h5>Tổng tiền: <span>{{ number_format($subtotal, 0, ',', '.') }} VNĐ</span></h5>
        </div>

        <div class="btn-wrapper" style="display: flex; flex-direction: column; gap: 10px;">
            <a href="{{ route('cart.index') }}" class="theme-btn-1 btn">
                Xem giỏ hàng
            </a>

            @if ($blockCheckout)
                <a href="javascript:void(0)"
                   class="theme-btn-2 btn"
                   style="opacity: 0.5; cursor: not-allowed; background: #ccc;">
                    Thanh toán
                </a>

                <p style="color: red; margin: 0; font-size: 13px; font-weight: bold; text-align: center;">
                    <i class="fas fa-exclamation-circle"></i>
                    Vui lòng bỏ sản phẩm lỗi khỏi giỏ hàng
                </p>
            @else
                <a href="{{ route('checkout') }}" class="theme-btn-2 btn" style="margin-right: 12px">
                    Thanh toán
                </a>
            @endif
        </div>
    </div>
@endif

