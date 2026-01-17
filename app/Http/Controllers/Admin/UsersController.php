<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('role');

        // 1. Lọc theo Vai trò (Role)
        if ($request->has('role_name') && $request->role_name != '') {
            $roleName = $request->role_name;
            $query->whereHas('role', function ($q) use ($roleName) {
                $q->where('name', $roleName);
            });
        }

        // 2. Lọc theo Trạng thái (Status)
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Lấy dữ liệu (Không dùng paginate nếu dùng DataTables full tính năng,
        // nhưng ở đây mình giữ get() hoặc paginate() tùy config DataTables của bạn)
        $users = $query->latest()->get();

        return view('admin.pages.users', compact('users'));
    }




    public function upgrade(Request $request)
    {
        $userId = $request->user_id;

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy người dùng.',
            ]);
        }

        $user->role_id = 2;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Đã update thành nhân viên.',
        ]);
    }



    // Hàm xử lý chung cho việc: Xóa, Chặn, Bỏ chặn, Khôi phục
    public function changeStatus(Request $request)
    {
        $userId = $request->user_id;
        $status = $request->status;

        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Không tìm thấy người dùng.',
            ]);
        }


        $user->status = $status;
        $user->save();


        $msg = 'Đã cập nhật trạng thái thành công.';
        if($status == 'delete') $msg = 'Đã xóa người dùng thành công.';
        if($status == 'banned') $msg = 'Đã chặn người dùng.';
        if($status == 'active') $msg = 'Đã khôi phục trạng thái hoạt động.';

        return response()->json([
            'status' => true,
            'message' => $msg,
        ]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'phone_number' => 'required|digits:10',
            'address' => 'nullable|string',
        ], [
            'name.required' => 'Vui lòng nhập họ tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã tồn tại.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải từ 6 ký tự.',
            'phone_number.required' => 'Vui lòng nhập số điện thoại.',
            'phone_number.digits' => 'Số điện thoại phải 10 số.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mã hóa mật khẩu
            'phone_number' => $request->phone_number,
            'address' => $request->address,
            'role_id' => 2, // <--- 2 là ID của STAFF (Nhân viên)
            'status' => 'active', // Mặc định là hoạt động
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Thêm nhân viên mới thành công!',
        ]);
    }




}
