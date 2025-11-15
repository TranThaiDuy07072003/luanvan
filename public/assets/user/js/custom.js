const { data } = require("alpinejs");

$(document).ready(function() {

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
    e.preventDefault(); // NGĂN FORM SUBMIT THƯỜNG

    let formData = new FormData(this);
    let urlUpdate = $(this).attr("action");

    // CSRF
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

                // CẬP NHẬT LẠI INPUT BẰNG DỮ LIỆU MỚI TỪ SERVER
                $('#ltn__name').val(response.user.name);
                $('#ltn__phone_number').val(response.user.phone_number);
                $('#ltn__address').val(response.user.address ?? ''); // dùng ?? để tránh undefined

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







});
