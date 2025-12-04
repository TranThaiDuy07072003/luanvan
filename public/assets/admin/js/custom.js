$(document).ready(function(){

    /*********************************
     * MANAGEMENT USERS
     *********************************/
    $(document).on('click', '.upgradeStaff', function(e){
        let button = $(this);
        let userId = button.data('userid');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/admin/user/upgrade',
            data: {
                user_id : userId,
            },
            success: function (response) {
                if(response.status){
                    toastr.success(response.message);
                    button.closest('.profile_view').find('.brief i').text('STAFF');
                    button.closest('.profile_view').find('.changeStatus').hide();
                    button.hide();
                }else{
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                alert('Có lỗi xảy ra: ' + error);
            },
        });



    });



    // Xử lý nút thay đổi trạng thái (Xóa/Chặn/Khôi phục)
    $(document).on('click', '.changeStatus', function(e){
        e.preventDefault(); // Ngăn load lại trang

        let button = $(this);
        let userId = button.data('userid');
        let status = button.data('status'); // Lấy trạng thái muốn đổi thành

        // Hỏi xác nhận nếu là hành động xóa
        if(status == 'delete'){
            if(!confirm('Bạn có chắc chắn muốn xóa người này không?')) return;
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: "POST",
            url: '/admin/user/change-status', // URL trùng với Route ở Bước 2
            data: {
                user_id : userId,
                status: status
            },
            success: function (response) {
                if(response.status){
                    toastr.success(response.message);
                    // Reload trang để cập nhật lại giao diện nút bấm
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }else{
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                alert('Có lỗi xảy ra: ' + error);
            },
        });
    });


    $('.btn_reset').on('click', function() {
        let form = $(this).closest('form');
        form.trigger('reset');
        form.find('input[type="file"]').val('');
        form.find('#image-preview').html('');
        form.find('#image-preview').attr('src', '');


        form.find('#image-preview-container').html('');

    });





    /*********************************
     * MANAGEMENT USERS
     *********************************/


    $("#category-image").change(function () {
        let file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $("#image-preview").attr("src", e.target.result);
            }
            reader.readAsDataURL(file);
        } else {
            $("#image-preview").attr("src", "");


        }
    });


    $(".category-image").change(function () {
        let file = this.files[0];
        let categoryId = $(this).data("id");
        if (file) {
            let reader = new FileReader();
            reader.onload = function (e) {
                $(".image-preview").each(function () {
                    if (
                        $(this).closest(".modal").attr("id") ===
                        "modalUpdate-" + categoryId
                    ) {
                        $(this).attr("src", e.target.result);
                    }
                });
            };
            reader.readAsDataURL(file);
        } else {
            $("#image-preview").attr("src", "");
        }
    });



    //update category
    $(document).on("click", ".btn-update-submit-category", function(e){
        e.preventDefault();
        let button = $(this);
        let categoryId = button.data("id");
        let form = button.closest(".modal").find("form");
        let formData = new FormData(form[0]);

        formData.append("category_id", categoryId);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: "categories/update",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                button.prop("disabled", true);
                button.text("Đang cập nhật...");
            },
            success: function (response) {
                if (response.status) {
                    toastr.success(response.message);
                    let categoryId = response.data.id;

                    // Regenerate new HTML for updated now
                    //Regenerate new HTML for updated row
                    let newRow = `
                        <tr id="category-row-${categoryId}">
                            <td>
                                <img src="${response.data.image}" alt="${response.data.name}"  width="80px">
                            </td>

                            <td>${response.data.name}</td>
                            <td>${response.data.slug}</td>
                            <td>${response.data.description}</td>

                            <td>
                                 <a class="btn btn-app btn-update-category" data-toggle="modal"
                                    data-target="#modalUpdate-${categoryId}">
                                        <i class="fa fa-edit"></i>Chỉnh sửa
                                 </a>

                            </td>

                            <td>
                                <a class="btn btn-app btn-delete-category" data-id="${categoryId}">
                                    <i class="fa fa-trash"></i>Xóa
                                </a>

                            </td>


                        </tr>`;

                        // Replace the old row with the new row
                        $('#category-row-' + categoryId).replaceWith(newRow);
                        $('#modalUpdate-' + categoryId).modal('hide');

                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                alert("Có lỗi xảy ra: " + error);
            },
            complete: function () {
                button.prop("disabled", false);
                button.text("Chỉnh sửa");
            },
        });


    });



    //delete category
    $(document).on("click", ".btn-delete-category", function(e){
        e.preventDefault();
        let button = $(this);
        let categoryId = button.data("id");
        let row = button.closest("tr");

        if(!confirm('Bạn có chắc chắn muốn xóa danh mục này không?')) return;

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: "categories/delete",
            type: "POST",
            data: {
                category_id: categoryId,
            },
            success: function (response) {
                if (response.status) {
                    toastr.success(response.message);
                    // Remove the deleted category row from the table
                    row.remove();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                alert("Có lỗi xảy ra: " + error);
            },
        });
    });





    /*********************************
     * MANAGEMENT - Products
     *********************************/
    // lay hinh
    $("#product-images").change(function (e) {
        let files = e.target.files;
        console.log(files);
        let previewContainer = $("#image-preview-container");
        previewContainer.empty();

        if (files.length > 0) {
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        let img = $("<img>")
                            .attr("src", e.target.result)
                            .addClass("image-preview");
                            img.css({
                                "max-width": "150px",
                                "max-height": "150px",
                                "margin": "5px",
                                "border-radius": "5px",
                            })
                        previewContainer.append(img);
                    };
                    reader.readAsDataURL(file);
                }
            }
        } else {
            previewContainer.html("");
        }
    });




    $(".product-images").change(function (e) {
        let files = e.target.files;
        let productId = $(this).data("id");

        let previewContainer = $("#image-preview-container-" + productId);
        previewContainer.empty();

        if (files.length > 0) {
            for (let i = 0; i < files.length; i++) {
                let file = files[i];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        let img = $("<img>")
                            .attr("src", e.target.result)
                            .addClass("image-preview");
                            img.css({
                                "max-width": "150px",
                                "max-height": "150px",
                                "margin": "5px",
                                "border-radius": "5px",
                            })
                        previewContainer.append(img);
                    };
                    reader.readAsDataURL(file);
                }
            }
        } else {
            previewContainer.html("");
        }
    });




    //update product
    $(document).on("click", ".btn-update-submit-product", function(e){
        e.preventDefault();
        let button = $(this);
        let productId = button.data("id");
        let form = button.closest(".modal").find("form");
        let formData = new FormData(form[0]);

        formData.append("id", productId);
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: "product/update",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                button.prop("disabled", true);
                button.text("Đang cập nhật...");
            },
            success: function (response) {
                if (response.status) {


                    let product = response.data;

                    let productId = product.id;

                    // let imageSrc = product.images.length > 0 ? product.images[0].url : "storage/products/default-product.png";

                    // Dùng image_url từ Controller trả về
                    let imageSrc = product.image_url;

                    // Regenerate new HTML for updated now
                    //Regenerate new HTML for updated row
                    let newRow = `
                        <tr id="product-row-${productId}">
                            <td>
                                <img src="${imageSrc}" alt="${product.name}" class="image-product"  width="80px">
                            </td>

                            <td>${product.name}</td>
                            <td>${product.category_name}</td>
                            <td>${product.slug}</td>
                            <td>${product.description}</td>
                            <td>${product.stock}</td>
                            <td>${product.price_formatted} VND</td>
                            <td>${product.unit}</td>
                            <td>${product.status}</td>


                            <td>
                                 <a class="btn btn-app btn-update-product" data-toggle="modal"
                                    data-target="#modalUpdate-${productId}">
                                        <i class="fa fa-edit"></i>Chỉnh sửa
                                 </a>

                            </td>

                            <td>
                                <a class="btn btn-app btn-delete-product" data-id="${productId}" data-status="${product.status}">
                                    <i class="fa fa-close"></i>Xóa
                                </a>

                            </td>
                        </tr>`;

                        // Replace the old row with the new row
                        $('#product-row-' + productId).replaceWith(newRow);

                        toastr.success(response.message);
                        $('#modalUpdate-' + productId).modal('hide');

                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                alert("Có lỗi xảy ra: " + error);
            },
            complete: function () {
                button.prop("disabled", false);
                button.text("Chỉnh sửa");
            },
        });
    });






    //delete product
    $(document).on("click", ".btn-delete-product", function(e){
        e.preventDefault();
        let button = $(this);
        let productId = button.data("id");

        let status = button.data("status"); // Lấy trạng thái từ nút bấm
        // --- KIỂM TRA NGAY TẠI ĐÂY ---
        if (status === 'in_stock') {
            toastr.warning('Sản phẩm đang bán (Còn hàng) không được phép xóa! Vui lòng chuyển trạng thái sang Hết hàng trước.');
            return; // Dừng lại ngay, không chạy tiếp code bên dưới
        }

        let row = button.closest("tr");

        if(!confirm('Bạn có chắc chắn muốn xóa sản phẩm này không?')) return;

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });

        $.ajax({
            url: "product/delete",
            type: "POST",
            data: {
                id: productId,
            },
            success: function (response) {
                if (response.status) {
                    toastr.success(response.message);
                    // Remove the deleted product row from the table
                    row.remove();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                alert("Có lỗi xảy ra: " + error);
            },
        });
    });






    /*********************************
     * MANAGEMENT - Order (quản lý quản trị đơn hàng, nghĩa là mình có thể quyết định xem
     * có duyệt đơn hàng hay không)
     *********************************/
    $(document).on("click", ".confirm-order", function(e){
        e.preventDefault();
        let button = $(this);
        let orderId = button.data("id");

        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });


        $.ajax({
            type: "POST",
            url: "order/confirm",
            data: {
                id: orderId,
            },
            success: function (response) {
                if (response.status) {
                    toastr.success(response.message);
                    button
                        .closest("tr")
                        .find(".order-status")
                        .html(
                            '<span class="custom-badge badge badge-info">Đang giao hàng</span>'
                        );
                    button.hide();
                } else {
                    toastr.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                alert("An error occurred: " + error);
            }
        });



    });





});
