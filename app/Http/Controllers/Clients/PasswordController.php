<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Mail\PasswordResetMail;
use Illuminate\Support\Facades\Mail;

class PasswordController extends Controller
{
    public function showForgotForm()
    {
        return view('auth.quenmatkhau');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email này không tồn tại trong hệ thống.'
        ]);

        $user = User::where('email', $request->email)->first();
        $token = Str::random(64);

        $user->activation_token = $token;
        $user->save();

        Mail::to($user->email)->send(new PasswordResetMail($token, $user->email));

        toastr()->success('Liên kết đặt lại mật khẩu đã được gửi đến email của bạn!');
        return back();
    }

    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.resetmatkhau')->with([
            'token' => $token,
            'email' => $request->query('email')
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required'
        ]);

        $user = User::where('email', $request->email)
                    ->where('activation_token', $request->token)
                    ->first();

        if (!$user) {
            toastr()->error('Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.');
            return back();
        }

        $user->password = Hash::make($request->password);
        $user->activation_token = null;
        $user->save();

        toastr()->success('Đặt lại mật khẩu thành công! Vui lòng đăng nhập.');
        return redirect()->route('login');
    }
}
