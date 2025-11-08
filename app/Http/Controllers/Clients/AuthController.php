<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('user.pages.register');
    }

    public function register(Request $request)
    {
        // Validate backend
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Định dạng email không hợp lệ',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',

        ]);


        // Kiểm tra email đã tồn tại hay chưa
        $existingUser = User::where('email', $request->email)->first();

        if ($existingUser) {
            if ($existingUser->isPending()) {
                toastr()->error('Email đã được sử dụng. Vui lòng chọn email khác.');
                return redirect()->route('register');
            }
            return redirect()->route('register');
        }


        // Tạo mã xác nhận email
        $token = Str::random(64);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'pending',
            'role_id'=> 3,
            'activation_token' => $token,
        ]);

        toastr()->success('Đăng ký thành công! Vui lòng kiểm tra email để kích hoạt tài khoản.');
        return redirect()->back();


    }
}
