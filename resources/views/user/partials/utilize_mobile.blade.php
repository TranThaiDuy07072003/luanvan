<!-- Utilize Mobile Menu Start -->
<div id="ltn__utilize-mobile-menu" class="ltn__utilize ltn__utilize-mobile-menu">
    <div class="ltn__utilize-menu-inner ltn__scrollbar">
        <div class="ltn__utilize-menu-head">
            <div class="site-logo">
                <a href="\"><img src="{{ asset('assets/user/img/logo01.png') }}" alt="Logo"></a>
            </div>
            <button class="ltn__utilize-close">×</button>
        </div>
        <div class="ltn__utilize-menu-search-form">
            <form id="#" method="GET" action="{{ route('search') }}">
                <input type="text" name="keyword" value="" placeholder="Tìm kiếm..." />
                <button type="submit">
                    <span><i class="icon-search"></i></span>
                </button>
            </form>
        </div>
        <div class="ltn__utilize-menu">
            <ul>
                <li><a href="\">Trang chủ</a> </li>
                    <li><a href="#">Về chúng tôi</a>
                    <ul>
                        <li><a href="{{ route('about') }}">Nông Sản Sạch là gì ?</a></li>
                        <li><a href="{{ route('faq') }}">Những Câu Hỏi Thường Gặp</a></li>
                    </ul>
                </li>
                <li><a href="{{ route('products.index') }}">Sản phẩm</a></li>
                <li><a href="{{ route('client.recipes') }}">Gợi ý món ăn</a> </li>
                <li><a href="{{ route('contact.index') }}">Liên hệ</a></li>
            </ul>
        </div>
        <div class="ltn__utilize-buttons ltn__utilize-buttons-2">
            <ul>
                <li>
                    <a href="{{ route('account') }}" title="Tài khoản">
                        <span class="utilize-btn-icon">
                            <i class="far fa-user"></i>
                        </span>
                        Tài khoản
                    </a>
                </li>
                {{-- <li>
                        <a href="wishlist.html" title="Yêu thích">
                            <span class="utilize-btn-icon">
                                <i class="far fa-heart"></i>
                                <sup>3</sup>
                            </span>
                            Yêu thích
                        </a>
                    </li> --}}
                <li>
                    <a href="{{route('cart.index')}}" title="Giỏ hàng">
                        <span class="utilize-btn-icon">
                            <i class="fas fa-shopping-cart"></i>
                            <sup id="cart_count">
                                @auth
                                    {{ \App\Models\CartItem::where('user_id', auth()->id())->sum('quantity')  }}
                                @else
                                    {{ session('cart') ? array_sum(array_column(session('cart'), 'quantity')) : 0 }}
                                @endauth
                            </sup>
                        </span>
                        Giỏ hàng
                    </a>
                </li>
            </ul>
        </div>
        <div class="ltn__social-media-2">
            <ul>
                <li><a href="javascript:void(0)" title="Facebook"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="javascript:void(0)" title="Twitter"><i class="fab fa-twitter"></i></a></li>
                <li><a href="javascript:void(0)" title="Linkedin"><i class="fab fa-linkedin"></i></a></li>
                <li><a href="javascript:void(0)" title="Instagram"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
    </div>
</div>
<!-- Utilize Mobile Menu End -->
