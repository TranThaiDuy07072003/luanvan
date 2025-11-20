<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $addresses = ShippingAddress::where('user_id', Auth::id())->get();
        return view('user.pages.account', compact('user', 'addresses'));
    }

    public function update(Request $request)
    {
        $request->validate(
            [
                'ltn__name' => 'required|string|max:255',
                'ltn__phone_number' => 'required|digits:10',
                'ltn__address' => 'nullable|string|max:100',
            ],
            [
                'ltn__name.required' => 'Họ và tên không được để trống.',
                'ltn__phone_number.required' => 'Vui lòng nhập số điện thoại.',
                'ltn__phone_number.digits' => 'Số điện thoại phải có đúng 10 số.',
                'ltn__address.max' => 'Địa chỉ không được vượt quá 100 ký tự.',
            ]
        );

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $user->name = $request->ltn__name;
        $user->phone_number = $request->ltn__phone_number;
        $user->address = $request->ltn__address;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Cập nhật thông tin thành công!',
            'user' => [
                'name' => $user->name,
                'phone_number' => $user->phone_number,
                'address' => $user->address,
            ],
        ]);
    }



    public function changePassword(Request $request)
    {
        $request->validate(
            [
                'current_password' => 'required',
                'new_password' => 'required|string|min:8|confirmed',
            ],
            [
                'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
                'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
                'new_password.min' => 'Mật khẩu mới phải có ít nhất 8 ký tự.',
                'new_password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            ]
        );

        /** @var \App\Models\User $user */
        $user = Auth::user();

        
        if (!Hash::check($request->current_password, $user->password)) {
            // Trả về lỗi đúng cấu trúc để Toastr bắt được
            return response()->json([
                'errors' => [
                    'current_password' => ['Mật khẩu hiện tại không chính xác.']
                ]
            ], 422);
        }

        // SỬA LẠI: Dùng Hash::make
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Đổi mật khẩu thành công!',
        ]);
    }




    public function addAddress(Request $request)
    {
        // Validation dữ liệu đầu vào
        $request->validate([
            'full_name' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'address' => 'required|string|min:5',
            'city' => 'required|string|min:2',
        ], [
            'full_name.required' => 'Họ tên không được để trống.',
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.digits' => 'Số điện thoại phải có đúng 10 chữ số.',
            'address.required' => 'Địa chỉ không được để trống.',
            'address.min' => 'Địa chỉ phải có ít nhất 5 ký tự.',
            'city.required' => 'Thành phố không được để trống.',
            'city.min' => 'Thành phố phải có ít nhất 2 ký tự.',
        ]);

        if ($request->has('default')) {
            ShippingAddress::where('user_id', Auth::id())->update(['default' => 0]);
        }

        ShippingAddress::create([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'city' => $request->city,
            'default' => $request->has('default') ? 1 : 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Địa chỉ đã được thêm thành công!',
        ]);
    }




    public function updatePrimaryAddress($id)
    {
        $address = ShippingAddress::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Đặt tất cả địa chỉ của người dùng là không mặc định
        ShippingAddress::where('user_id', Auth::id())->update(['default' => 0]);

        // Đặt địa chỉ được chọn là mặc định
        $address->default = 1;
        $address->save();

        return response()->json([
            'success' => true,
            'message' => 'Địa chỉ mặc định đã được cập nhật thành công!',
        ]);
    }



    public function deleteAddress($id)
    {
        $address = ShippingAddress::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Nếu là địa chỉ mặc định, không cho xóa
        if ($address->default) {
            return response()->json([
                'message' => 'Không thể xóa địa chỉ mặc định. Vui lòng chọn địa chỉ khác làm mặc định trước.',
            ], 422);
        }

        $address->delete();

        return response()->json([
            'success' => true,
            'message' => 'Địa chỉ đã được xóa thành công!',
        ]);
    }











}
