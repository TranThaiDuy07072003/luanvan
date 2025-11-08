$(document).ready(function() {
    // Your code here (giữ nguyên phần comment nếu cần)

    $("#register-form").submit(function(e) {
        // Lấy giá trị các input - thêm .trim() để loại bỏ khoảng trắng thừa ở đầu/cuối
        let name = $('input[name="name"]').val().trim();
        let email = $('input[name="email"]').val().trim();
        let password = $('input[name="password"]').val();  // Không trim password để giữ nguyên ký tự
        let confirmPassword = $('input[name="password_confirmation"]').val();  // Giữ để khớp view

        let errorMessages = "";

        // Kiểm tra name (giữ nguyên, nhưng giờ có trim nên chính xác hơn)
        if (name.length < 3) {
            errorMessages += "Họ tên phải có ít nhất 3 ký tự.\n";
        }

        // Kiểm tra email regex (giữ nguyên)
        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            errorMessages += "Địa chỉ email không hợp lệ.\n";
        }

        // Kiểm tra password length (giữ nguyên)
        if (password.length < 6) {
            errorMessages += "Mật khẩu phải có ít nhất 6 ký tự.\n";
        }

        // Kiểm tra matching password (giữ nguyên, nhưng giờ confirmPassword lấy đúng giá trị)
        if (password !== confirmPassword) {
            errorMessages += "Mật khẩu và xác nhận mật khẩu không khớp.\n";
        }

        // Nếu có lỗi, prevent submit và hiển thị toastr (giữ nguyên)
        if (errorMessages !== "") {
            e.preventDefault();
            toastr.error(errorMessages, "Lỗi xác thực", {"timeOut": 5000});
        }
        // Nếu không lỗi, form sẽ submit bình thường (không cần code thêm)
    });
});
