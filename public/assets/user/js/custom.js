$(document).ready(function() {
    // Your code here


    $("#register-form").submit(function(e) {
        let name = $('input[name="name"]').val();
        let email = $('input[name="email"]').val();
        let password = $('input[name="password"]').val();
        let confirmPassword = $('input[name="confirmPassword"]').val();
        let checkbox1 = $('input[name="checkbox1"]').is(':checked');
        let checkbox2 = $('input[name="checkbox2"]').is(':checked');


        let errorMessages = "";

        if(name.length < 3) {
            errorMessages += "Họ tên phải có ít nhất 3 ký tự.\n";
        }


        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if(!emailRegex.test(email)) {
            errorMessages += "Địa chỉ email không hợp lệ.\n";
        }

        if(password.length < 6) {
            errorMessages += "Mật khẩu phải có ít nhất 6 ký tự.\n";
        }

        if(password !== confirmPassword) {
            errorMessages += "Mật khẩu và xác nhận mật khẩu không khớp.\n";
        }

        if(!checkbox1) {
            errorMessages += "Bạn phải đồng ý với điều khoản sử dụng.\n";
        }

        if(!checkbox2) {
            errorMessages += "Bạn phải đồng ý với chính sách bảo mật.\n";
        }

        if(errorMessages !== "") {
             e.preventDefault();
             toastr.error(errorMessages, "Lỗi xác thực", {"timeOut": 5000});
        }
    });
});










