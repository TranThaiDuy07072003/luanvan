<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::with('role')->paginate(9);

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








}
