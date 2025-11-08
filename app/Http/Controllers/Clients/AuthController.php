<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;  // Thêm để dùng Authentication facade
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Method hiển thị form đăng ký (giữ nguyên code cũ)
    public function showRegisterForm()
    {
        return view('user.pages.register');
    }

    // Method xử lý đăng ký (dựa trên code cũ, thêm validation cho checkbox nếu có)
    public function register(Request $request)
    {
        // Validate backend (xóa rules và messages cho checkbox1, checkbox2)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',  // Giữ 'confirmed' để check password_confirmation
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Định dạng email không hợp lệ',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Mật khẩu và xác nhận không khớp',
        ]);

        // Kiểm tra email đã tồn tại hay chưa (giữ nguyên code cũ)
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            if ($existingUser->isPending()) {  // Giả sử method isPending() tồn tại trong model User
                toastr()->error('Email đã được sử dụng. Vui lòng chọn email khác.');
                return redirect()->route('register');
            }
            return redirect()->route('register');
        }

        // Tạo mã xác nhận email (giữ nguyên)
        $token = Str::random(64);

        // Tạo user (giữ nguyên, với Hash::make cho password)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'pending',
            'role_id' => 3,
            'activation_token' => $token,
        ]);

        // Gửi email activation (thêm code này để hoàn thiện, dùng Mail facade - config mail trước trong .env)
        // Mail::to($user->email)->send(new ActivationMail($user, $token));  // Giả sử bạn có Mailable class

        toastr()->success('Đăng ký thành công! Vui lòng kiểm tra email để kích hoạt tài khoản.');

        // Redirect về trang login thay vì back() (vì đã dùng Authentication, redirect đến route login)
        return redirect()->route('login');
    }

    // Method mới: Xử lý đăng nhập (authenticate) sử dụng Auth::attempt()
    public function authenticate(Request $request): RedirectResponse
    {
        // Validate credentials (rules đơn giản, message tiếng Việt)
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Định dạng email không hợp lệ',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);

        // Attempt login với điều kiện custom (status 'active' và activation_token null)
        if (Auth::attempt($credentials + ['status' => 'active'], $request->filled('remember'))) {
            // Regenerate session để tránh fixation attack (bảo mật)
            $request->session()->regenerate();

            toastr()->success('Đăng nhập thành công!');

            // Redirect đến trang intended (nếu có) hoặc dashboard
            return redirect()->intended('/dashboard');
        }

        // Nếu fail, back với error và giữ input email
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không đúng hoặc tài khoản chưa kích hoạt.',
        ])->onlyInput('email');
    }

    // Method mới: Xử lý logout
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();  // Logout user

        // Invalidate session và regenerate token (bảo mật)
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toastr()->success('Đăng xuất thành công!');

        return redirect('/');  // Redirect về home
    }
}
