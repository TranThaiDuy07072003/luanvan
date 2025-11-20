// const { data } = require("alpinejs");

$(document).ready(function() {

    // --- CẤU HÌNH CHUNG ---

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    // Xác thực form đăng ký trước khi submit (validate register form)
    $("#register-form").submit(function(e) {

        let name = $('input[name="name"]').val().trim();
        let email = $('input[name="email"]').val().trim();
        let password = $('input[name="password"]').val();
        let confirmPassword = $('input[name="password_confirmation"]').val();  // Giữ để khớp view

        let errorMessages = "";


        if (name.length < 3) {
            errorMessages += "Họ tên phải có ít nhất 3 ký tự.\n";
        }


        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            errorMessages += "Địa chỉ email không hợp lệ.\n";
        }


        if (password.length < 6) {
            errorMessages += "Mật khẩu phải có ít nhất 6 ký tự.\n";
        }


        if (password !== confirmPassword) {
            errorMessages += "Mật khẩu và xác nhận mật khẩu không khớp.\n";
        }


        if (errorMessages !== "") {
            e.preventDefault();
            toastr.error(errorMessages, "Lỗi xác thực", {"timeOut": 5000});
        }

    });




    $("#login-form").submit(function(e) {
        toastr.clear();
        let email = $('input[name="email"]').val().trim();
        let password = $('input[name="password"]').val();

        let errorMessages = "";



        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            errorMessages += "Địa chỉ email không hợp lệ.\n";
        }


        if (password.length < 6) {
            errorMessages += "Mật khẩu phải có ít nhất 6 ký tự.\n";
        }



        if (errorMessages !== "") {
            e.preventDefault();
            toastr.error(errorMessages, "Lỗi xác thực", {"timeOut": 5000});
        }

    });



    $("#update-account").on("submit", function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let urlUpdate = $(this).attr("action");

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: urlUpdate,
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,

                beforeSend: function() {
                    toastr.info("Đang cập nhật thông tin...", "Vui lòng chờ");
                },

                success: function(response) {
                    if (response.success) {
                        toastr.success(response.message, "Thành công");

                        $('#ltn__name').val(response.user.name);
                        $('#ltn__phone_number').val(response.user.phone_number);
                        $('#ltn__address').val(response.user.address ?? '');

                } else {
                    toastr.error(response.message || "Cập nhật thất bại", "Lỗi");
                }
        },

                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors || { general: ['Lỗi hệ thống'] };
                    let msg = Object.values(errors).flat().join('<br>');
                    toastr.error(msg, "Lỗi xác thực");
                }
            });
    });



    // Validate form address
    $("#addAddressForm").submit(function(e) {
        e.preventDefault();

        let isvalid = true;
        $('.error-message').remove();

        let fullname = $('#full_name').val().trim();
        let phone = $('#phone').val().trim();
        let address = $('#address').val().trim();
        let city = $('#city').val().trim();

        // Validate fullname
        if (fullname.length < 3) {
            isvalid = false;
            $('#full_name').after('<p class="error-message text-danger">Họ tên phải có ít nhất 3 ký tự.</p>');
        }

        // Validate phone
        let phoneRegex = /^[0-9]{10,11}$/;
        if (!phoneRegex.test(phone)) {
            isvalid = false;
            $('#phone').after('<p class="error-message text-danger">Số điện thoại phải có 10-11 chữ số.</p>');
        }

        // Validate address
        if (address.length < 5) {
            isvalid = false;
            $('#address').after('<p class="error-message text-danger">Địa chỉ phải có ít nhất 5 ký tự.</p>');
        }

        // Validate city
        if (city.length < 2) {
            isvalid = false;
            $('#city').after('<p class="error-message text-danger">Thành phố không được để trống.</p>');
        }

        if (isvalid) {
            let formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                beforeSend: function() {
                    toastr.info('Đang lưu địa chỉ...', 'Vui lòng chờ');
                    $('button[type="submit"]').prop('disabled', true);
                },
                success: function(response) {
                    // Laravel redirect → không trả JSON → nên dùng redirect JS
                    toastr.success('Thêm địa chỉ thành công!', 'Thành công');
                    setTimeout(() => {
                        location.reload(); // Tải lại trang để thấy địa chỉ mới
                    }, 1000);
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $('.error-message').remove(); // Xóa lỗi cũ
                        $.each(errors, function(key, value) {
                            let input = $('#' + key.replace('.', '_')); // fullname → full_name
                            if (input.length) {
                                input.after('<p class="error-message text-danger">' + value[0] + '</p>');
                            }
                        });
                        toastr.error('Vui lòng kiểm tra lại thông tin.', 'Lỗi nhập liệu');
                    } else {
                        toastr.error('Lỗi hệ thống. Vui lòng thử lại.', 'Lỗi');
                    }
                },
                complete: function() {
                    $('button[type="submit"]').prop('disabled', false);
                }
            });
        }
    })




    /*********************************
     * PAGE PRODUCTS
     *********************************/

    function fetchProducts() {
        let category_id = $(".category-filter.active").data('id') || '';
        let sort_by = $("#sort-by").val()


        $.ajax({
            url: '/products/filter', // (Lỗi 4: Sửa thành URL tuyệt đối)
            type: "GET",
            data: {
                category_id: category_id,
                sort_by: sort_by,
            },
            beforeSend: function() {
                $("#loading-spinner").show();
                $("#liton_product_grid").hide();
                $("#pagination-links").hide(); // Ẩn cả phân trang cũ
            },
            success: function(response) {
                // Cập nhật lại lưới sản phẩm
                $("#liton_product_grid").html(response.products_html);
                // Cập nhật lại link phân trang
                $("#pagination-links").html(response.pagination_html);
            },
            complete: function() {
                $("#loading-spinner").hide();
                $("#liton_product_grid").show();
                $("#pagination-links").show(); // Hiện phân trang mới
            },
            error: function(xhr) {
                console.error(xhr.responseText); // Dùng console.error để xem lỗi rõ hơn
                alert('Có lỗi xảy ra khi lọc sản phẩm!');
            }
        });
    }


    // Khi click vào 1 danh mục
    // Đoạn code này trong custom.js của bạn đã RẤT ĐÚNG
    $(".category-filter").click(function(){
        $(".category-filter").removeClass('active'); // Xóa 'active' ở tất cả các link
        $(this).addClass('active'); // Thêm 'active' CHỈ cho link vừa bấm
        fetchProducts();
    })




    // Khi thay đổi sắp xếp
    $("#sort-by").change(function() {
        fetchProducts();
    });



    // Khi click vào link phân trang (AJAX)
    // Cần lắng nghe trên document vì link này bị thay đổi liên tục
    $(document).on('click', '#pagination-links .pagination a', function(e) {
        e.preventDefault(); // Ngăn chuyển trang
        let url = $(this).attr('href'); // Lấy URL của trang (ví dụ: /products/filter?page=2)

        if (!url) return;

        // Lấy category và sort_by hiện tại
        let category_id = $(".category-filter.active").data('id') || '';
        let sort_by = $("#sort-by").val();

        $.ajax({
            url: url, // Gửi đến URL của trang được click
            type: "GET",
            data: {
                category_id: category_id, // Gửi kèm bộ lọc
                sort_by: sort_by,
            },
             beforeSend: function() {
                $("#loading-spinner").show();
                $("#liton_product_grid").hide();
                $("#pagination-links").hide();
            },
            success: function(response) {
                $("#liton_product_grid").html(response.products_html);
                $("#pagination-links").html(response.pagination_html);
                // Tự động cuộn lên đầu danh sách sản phẩm
                $('html, body').animate({
                    scrollTop: $("#liton_product_grid").offset().top - 150 // Cuộn lên
                }, 500);
            },
            complete: function() {
                $("#loading-spinner").hide();
                $("#liton_product_grid").show();
                $("#pagination-links").show();
            },
            error: function (xhr) {
                alert('Có lỗi khi chuyển trang!');
            }
        });
    });







/*********************************
     * PAGE PRODUCTS
*********************************/
    $(document).on('click', '.qtybutton', function() {
        console.log(16313125785);

        var $button = $(this);
        var $input = $button.siblings('input');
        var oldValue = parseInt($input.val());
        var maxStock = parseInt($input.data('max'));

        if ($button.hasClass('inc')) {
            if (oldValue < maxStock) {
                $input.val(oldValue + 1);
            }
        } else {
            if (oldValue > 1) {
                $input.val(oldValue - 1);
            }
        }
    });



    // Add to cart
    $(document).on('click', '.add-to-cart-btn', function(e) {
        e.preventDefault();

        let productId = $(this).data('id');
        // DÒNG MỚI (Tìm theo class cha, chắc chắn trúng):
        let quantity = $(this).closest('.ltn__product-details-menu-2').find('input[name="qtybutton"]').val();
        //let quantity = $(this).closest('li').prev().find('.cart-plus-minus-box').val();

        quantity = quantity ? quantity : 1;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/cart/add',
            type: "POST",
            data: {
                product_id : productId,
                quantity   : quantity,
            },
            success: function (response) {
                $('#add_to_cart_modal-' + productId).modal('show');
                $('#quick_view_modal-' + productId).modal('hide');

                $('#cart_count').text(response.cart_count);
            },
            error: function (xhr) {
                alert('Có lỗi xảy ra với ajax addToCart in Detail!');
            },
        });
    });








/*********************************
     * CARTs
*********************************/

// Xe đẩy trên cùng:

    $('.mini-cart-icon').on('click', function(e){
        $.ajax({
            url: '/mini-cart',
            type: 'GET',
            success:function(response){
                if(response.status)
                {
                    $('#ltn__utilize-cart-menu .ltn__utilize-menu-inner').html(response.html);
                    $('#ltn__utilize-cart-menu').addClass("ltn__utilize-open");
                }else{
                    toastr.error('Không thể tải giỏ hàng. Vui lòng tải lại trang !');
                }
            }
        });
    });

    $(document).on('click', '.ltn__utilize-close', function(){
        $('#ltn__utilize-cart-menu').removeClass("ltn__utilize-open");
        $('.ltn__utilize-overlay').hide(); //nó là class
    });


    //remove product from cart
    $(document).on('click', '.mini-cart-item-delete', function(){
        let productId = $(this).data('id');
        $.ajax({
            url: '/cart/remove',
            type: 'POST',
            data: {product_id: productId},
            success:function(response){
                if(response.status)
                {
                    $('#cart_count').text(response.cart_count);
                    $('.mini-cart-icon').click();
                }
            }
        });
    });



});
