@extends('layouts.client')

@section('title', 'Sản phẩm')

@section('breadcrumb', 'Sản phẩm')

@section('content')

    <!-- PRODUCT DETAILS AREA START -->
    <div class="ltn__product-area ltn__product-gutter">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 order-lg-2 mb-120">
                    <div class="ltn__shop-options">
                        <ul>
                            <li>
                                <div class="ltn__grid-list-tab-menu ">
                                    <div class="nav">
                                        <a class="active show" data-bs-toggle="tab" href="#liton_product_grid"><i
                                                class="fas fa-th-large"></i></a>

                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="short-by text-center">
                                    <select id="sort-by" class="nice-select">

                                        <option value="default">Sắp xếp mặc định</option>
                                        <option value="latest">Sắp xếp theo hàng mới về</option>
                                        <option value="price_asc">Sắp xếp theo giá: thấp đến cao</option>
                                        <option value="price_desc">Sắp xếp theo giá: cao đến thấp</option>

                                    </select>
                                </div>
                            </li>

                        </ul>
                    </div>
                    <div class="tab-content">
                        <div id="">
                            <div id="loader">

                            </div>
                        </div>

                        <!-- Lưới sản phẩm -->
                        <div class="tab-pane fade active show" id="liton_product_grid">
                            @include('user.components.products_grid' , ['products' => $products]) {{--$products này là do controller trả về --}}
                        </div>

                    </div>
                    <div class="ltn__pagination-area text-center">
                        <div class="ltn__pagination">

                            {!! $products->links('user.components.pagination.pagination_custom') !!}

                        </div>
                    </div>
                </div>
                <div class="col-lg-4  mb-120">
                    <aside class="sidebar ltn__shop-sidebar">
                        <!-- Category Widget -->
                        <div class="widget ltn__menu-widget">
                            <h4 class="ltn__widget-title ltn__widget-title-border">Danh Mục Sản Phẩm</h4>
                            <ul>

                                <!-- Thêm 1 link "Tất cả" để bỏ lọc -->
                                <li>
                                    <a href="javascript:void(0)" class="category-filter active" data-id="">Tất cả
                                       <span><i class="fas fa-long-arrow-alt-right"></i></span>
                                    </a>
                                </li>

                                @foreach ($categories as $category)
                                    <li>
                                        <a href="javascript:void(0)" class="category-filter"
                                           data-id="{{ $category->id }}">{{ $category->name }}
                                           <span><i class="fas fa-long-arrow-alt-right"></i></span>
                                        </a>
                                    </li>
                                @endforeach

                            </ul>
                        </div>
                        

                        <!-- Search Widget -->
                        <div class="widget ltn__search-widget">
                            <h4 class="ltn__widget-title ltn__widget-title-border">Tìm Kiếm</h4>
                            <form action="#">
                                <input type="text" name="search" placeholder="Nhập tên sản phẩm...">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>

                        <!-- Banner Widget -->
                        <div class="widget ltn__banner-widget">
                            <a href="{{ route('products.index') }}"><img
                                    src="{{ asset('assets/user/img/banner/banner-1.jpg') }}" alt="#"></a>
                        </div>

                    </aside>
                </div>
            </div>
        </div>
    </div>
    <!-- PRODUCT DETAILS AREA END -->


@endsection



@push('scripts')
<script>
    // $(document).ready(function() {

    //     // Hàm chính để gọi AJAX
    //     function fetchProducts(pageUrl = '{{ route('products.filter') }}') {
    //         let category_id = $(".category-filter.active").data('id') || '';
    //         let sort_by = $("#sort-by").val();

    //         $.ajax({
    //             url: pageUrl, // Dùng URL được truyền vào
    //             type: "GET",
    //             data: {
    //                 category_id: category_id,
    //                 sort_by: sort_by,
    //             },
    //             beforeSend: function() {
    //                 $("#loading-spinner").show();
    //                 $("#liton_product_grid").hide();
    //                 $("#pagination-links").hide(); // Ẩn phân trang cũ
    //             },
    //             success: function(response) {
    //                 $("#liton_product_grid").html(response.products_html);
    //                 // Cập nhật lại HTML của phân trang
    //                 $("#pagination-links").html(response.pagination_html);
    //             },
    //             complete: function() {
    //                 $("#loading-spinner").hide();
    //                 $("#liton_product_grid").show();
    //                 $("#pagination-links").show(); // Hiển thị phân trang mới
    //             },
    //             error: function(xhr) {
    //                 console.error(xhr.responseText);
    //                 alert('Có lỗi xảy ra khi lọc sản phẩm!');
    //             }
    //         });
    //     }

    //     // 1. Khi click vào 1 danh mục
    //     $(".category-filter").click(function() {
    //         $(".category-filter").removeClass('active');
    //         $(this).addClass('active');
    //         fetchProducts(); // Gọi hàm lọc (sẽ tự động lấy trang 1)
    //     });

    //     // 2. Khi thay đổi sắp xếp
    //     $("#sort-by").change(function() {
    //         // Cần khởi tạo lại niceSelect sau khi thay đổi (nếu bạn dùng plugin 'nice-select')
    //         // $(this).niceSelect('update');
    //         fetchProducts(); // Gọi hàm lọc (sẽ tự động lấy trang 1)
    //     });

    //     // 3. Khi click vào link phân trang (AJAX)
    //     // Phải dùng $(document).on(...) vì link này được load lại
    //     $(document).on('click', '#pagination-links .pagination a', function(e) {
    //         e.preventDefault(); // Ngăn chuyển trang
    //         let url = $(this).attr('href'); // Lấy URL của trang (ví dụ: /products/filter?page=2)

    //         if (!url) return;

    //         // Gọi hàm lọc với URL của trang mới
    //         fetchProducts(url);

    //         // Cuộn lên đầu danh sách sản phẩm
    //         $('html, body').animate({
    //             scrollTop: $("#liton_product_grid").offset().top - 150
    //         }, 500);
    //     });

    // });
</script>
@endpush
