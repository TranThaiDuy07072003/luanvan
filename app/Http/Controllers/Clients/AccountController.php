<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('user.pages.account', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                'ltn__name' => 'required|string|max:255',
                'ltn__phone_number' => 'required|digits:10', // <-- ĐÃ SỬA
                'ltn__address' => 'nullable|string|max:100',
            ],
            [
                // Tin nhắn tùy chỉnh (để Toastr hiển thị đẹp)
                'ltn__name.required' => 'Họ và tên không được để trống.',

                'ltn__phone_number.required' => 'Vui lòng nhập số điện thoại.',
                'ltn__phone_number.digits' => 'Số điện thoại phải có đúng 10 số.',

                'ltn__address.max' => 'Địa chỉ không được vượt quá 100 ký tự.',
            ]
        );

        $user = Auth::user();
        $user->name = $request->ltn__name;
        $user->phone_number = $request->ltn__phone_number;
        $user->address = $request->ltn__address;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công!',
            'user' => [ // GỬI LẠI DỮ LIỆU ĐỂ CẬP NHẬT INPUT
                'name' => $user->name,
                'phone_number' => $user->phone_number,
                'address' => $user->address,
            ],
        ]);
    }
}
