@if (isset($products) && count($products) > 0)
    <div class="row">
        @foreach ($products as $product)
            <div class="col-lg-4 col-md-6 col-6 mb-3">
                <div class="ltn__product-item ltn__product-item-3 text-center"
                    style="border: 1px solid #e5e5e5; border-radius: 8px; padding: 10px 5px; margin-bottom: 0;">

                    <div class="product-img">
                        <a href="{{ route('product.detail', $product->slug) }}" target="_blank">
                            @php
                                // 1. Mặc định là ảnh rỗng
                                $imgSrc = 'https://placehold.co/100x100?text=No+Image';

                                // 2. Ưu tiên lấy từ bảng phụ (product_images) do Admin upload vào đây
                                if ($product->images && $product->images->count() > 0) {
                                    $imgSrc = asset('storage/' . $product->images->first()->image);
                                }
                                // 3. Nếu không có, thử lấy từ cột image bảng chính (đề phòng dữ liệu cũ)
                                elseif (!empty($product->image)) {
                                    $imgSrc = asset('storage/' . $product->image);
                                }
                            @endphp

                            <img src="{{ $imgSrc }}" alt="{{ $product->name }}"
                                style="height: 100px; width: 100%; object-fit: contain; margin: 0 auto; z-index: 1;">
                        </a>
                    </div>

                    <div class="product-info mt-2">
                        <h2 class="product-title"
                            style="font-size: 13px; height: 35px; overflow: hidden; margin-bottom: 5px;">
                            <a href="{{ route('product.detail', $product->slug) }}"
                                target="_blank">{{ $product->name }}</a>
                        </h2>
                        <div class="product-price" style="margin-bottom: 10px;">
                            @if ($product->stock > 0 && $product->status == 'in_stock')
                                <span
                                    style="color: #d0021b; font-weight: bold;">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                            @else
                                <span style="color: #999;">Hết hàng</span>
                            @endif
                        </div>

                        {{-- KHU VỰC NÚT MUA --}}
                        @if ($product->stock > 0 && $product->status == 'in_stock')
                            <div class="product-action-bhx d-flex justify-content-center align-items-center"
                                style="gap: 5px;">

                                {{-- Bộ nút cộng trừ --}}
                                <div class="qty-container d-flex"
                                    style="border: 1px solid #ddd; border-radius: 4px; overflow: hidden; height: 30px;">
                                    <button type="button" class="btn-qty-minus"
                                        style="border: none; background: #f1f1f1; width: 25px; font-weight: bold;">-</button>
                                    <input type="text" value="1" class="input-qty-recipe"
                                        style="width: 30px; border: none; text-align: center; font-size: 13px; height: 30px; padding: 0;"
                                        readonly data-max="{{ $product->stock }}">
                                    <button type="button" class="btn-qty-plus"
                                        style="border: none; background: #f1f1f1; width: 25px; font-weight: bold;">+</button>
                                </div>

                                {{-- Nút Mua --}}
                                <button type="button" class="btn btn-success btn-add-recipe-item theme-btn-1"
                                    data-id="{{ $product->id }}"
                                    style="height: 30px; width: 35px; padding: 0; border: 0;">
                                    <i class="fas fa-shopping-cart" style="font-size: 14px; margin: 0; "></i>
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

    {{-- Nút THÊM TẤT CẢ --}}
    <div class="row mt-3">
        <div class="col-12">
            <button type="button" class="btn btn-success w-100 font-weight-bold btn-add-all-recipe theme-btn-1"
                style="">
                THÊM TẤT CẢ VÀO GIỎ
            </button>
        </div>
    </div>
@else
    <div class="text-center text-muted py-3">Chưa có nguyên liệu cho món này.</div>
@endif
