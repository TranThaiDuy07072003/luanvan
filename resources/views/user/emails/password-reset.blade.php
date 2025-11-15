@component('mail::message')
# Đặt lại mật khẩu

Bạn đã yêu cầu đặt lại mật khẩu. Vui lòng click nút bên dưới:

@component('mail::button', [
    'url' => route('password.reset', $token) . '?email=' . urlencode($email)
])
Đặt lại mật khẩu
@endcomponent

Nếu bạn không yêu cầu, vui lòng bỏ qua email này.

Trân trọng,<br>
{{ config('app.name') }}
@endcomponent
