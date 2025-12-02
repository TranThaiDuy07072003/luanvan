<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('user.pages.contact');
    }



    public function sendContact(Request $request)
    {
        // Validate dữ liệu từ form liên hệ
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|numeric|digits_between:10,15',
        ], [

            'name.required' => 'Vui lòng nhập họ tên của bạn.',
            'email.required' => 'Vui lòng nhập Email của bạn.',
            'phone.required' => 'Vui lòng nhập số điện thoại của bạn.',
        ]);


        Contact::create([
            'full_name' => $request->name,
            'phone_number' => $request->phone,
            'email' => $request->email,
            'message' => $request->message,
            'is_replied' => 0
        ]);

        // Xử lý lưu trữ hoặc gửi email liên hệ ở đây
        // Ví dụ: Lưu vào cơ sở dữ liệu hoặc gửi email cho quản trị viên

        // Trả về phản hồi cho người dùng
        toastr()->success('Cảm ơn bạn đã liên hệ với chúng tôi! Chúng tôi sẽ phản hồi sớm nhất có thể.');
        return redirect()->back();
    }


}
