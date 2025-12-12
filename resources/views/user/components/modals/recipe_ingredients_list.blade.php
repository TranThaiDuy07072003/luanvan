@if(isset($products) && count($products) > 0)
    <div class="row">
    @foreach($products as $product)
    <div class="col-lg-4 col-md-6 col-6 mb-3">
        <div class="ltn__product-item ltn__product-item-3 text-center" style="border: 1px solid #e5e5e5; border-radius: 8px; padding: 10px 5px; margin-bottom: 0;">
            <div class="product-img">
                <a href="{{ route('product.detail', $product->slug) }}" target="_blank">
                    {{-- SỬA LỖI ẢNH: Dùng image_url --}}
                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="height: 100px; width: 100%; object-fit: contain; margin: 0 auto;">
                </a>
            </div>
            <div class="product-info mt-2">
                <h2 class="product-title" style="font-size: 13px; height: 35px; overflow: hidden; margin-bottom: 5px;">
                    <a href="{{ route('product.detail', $product->slug) }}" target="_blank">{{ $product->name }}</a>
                </h2>
                <div class="product-price" style="margin-bottom: 10px;">
                    @if ($product->stock > 0 && $product->status == 'in_stock')
                        <span style="color: #d0021b; font-weight: bold;">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                    @else
                        <span style="color: #999;">Hết hàng</span>
                    @endif
                </div>

                {{-- KHU VỰC NÚT MUA (Dùng Flexbox để sửa lỗi rớt dòng) --}}
                @if ($product->stock > 0 && $product->status == 'in_stock')
                    <div class="product-action-bhx d-flex justify-content-center align-items-center" style="gap: 5px;">

                        {{-- Bộ nút cộng trừ (Viết HTML cứng để không phụ thuộc CSS cũ) --}}
                        <div class="qty-container d-flex" style="border: 1px solid #ddd; border-radius: 4px; overflow: hidden; height: 30px;">
                            <button type="button" class="btn-qty-minus" style="border: none; background: #f1f1f1; width: 25px; font-weight: bold;">-</button>
                            <input type="text" value="1" class="input-qty-recipe" style="width: 30px; border: none; text-align: center; font-size: 13px; height: 30px; padding: 0;" readonly data-max="{{ $product->stock }}">
                            <button type="button" class="btn-qty-plus" style="border: none; background: #f1f1f1; width: 25px; font-weight: bold;">+</button>
                        </div>

                        {{-- Nút Mua (Class riêng: btn-add-recipe-item) --}}
                        <button type="button" class="btn btn-success btn-add-recipe-item"
                                data-id="{{ $product->id }}"
                                style="height: 30px; width: 35px; padding: 0; background-color: #28a745; border-color: #28a745;">
                            <i class="fas fa-shopping-cart" style="font-size: 14px; margin: 0;"></i>
                        </button>
                    </div>
                @else
                    <button class="btn btn-secondary btn-sm" disabled style="font-size: 11px;">Hết hàng</button>
                @endif
            </div>
        </div>
    </div>
    @endforeach
    </div>

    {{-- Nút "THÊM TẤT CẢ VÀO GIỎ" (Màu xanh lá to ở dưới cùng) --}}
    <div class="row mt-3">
        <div class="col-12">
            <button type="button" class="btn btn-success w-100 font-weight-bold btn-add-all-recipe" style="background-color: #00a55d; color: white;">
                THÊM TẤT CẢ VÀO GIỎ
            </button>
        </div>
    </div>

@else
    <div class="text-center text-muted py-3">Chưa có nguyên liệu cho món này.</div>
@endif
