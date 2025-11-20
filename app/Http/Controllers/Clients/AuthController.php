<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ActivationMail;
use App\Models\CartItem; // <--- NHỚ THÊM DÒNG NÀY

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('user.pages.register');
    }

    public function showLoginForm()
    {
        return view('user.pages.login');
    }


    public function register(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Định dạng email không hợp lệ',
            'email.unique' => 'Email đã được sử dụng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Mật khẩu và xác nhận không khớp',
        ]);

        $token = Str::random(64);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'status' => 'pending',
            'role_id' => 3,
            'activation_token' => $token,
        ]);

        // SỬA: Gửi đúng tham số
        // Chỗ này lúc đăng ký gửi email kích hoạt
        Mail::to($user->email)->send(new ActivationMail($token, $user));

        toastr()->success('Đăng ký thành công! Vui lòng kiểm tra email để kích hoạt tài khoản.');

        return redirect()->route('login'); // ĐÚNG: về login
    }


    // Kích hoạt tài khoản
    public function activate($token): RedirectResponse
    {
        //Bước 1
        $user = User::where('activation_token', $token)->first();

        //Bước 2
        if (!$user) {
            toastr()->error('Link kích hoạt không hợp lệ hoặc đã hết hạn.');
            return redirect()->route('login');
        }

        //Bước 3 là kiểm tra mã kích hoạt
        if ($user->status === 'active') {
            toastr()->info('Tài khoản đã được kích hoạt trước đó.');
            Auth::login($user);
            return redirect()->route('home');
        }

        //Bước 4 là cập nhật trạng thái user từ "pending" qua "active"
        $user->status = 'active';
        $user->activation_token = null;
        $user->email_verified_at = now();
        $user->save();

        Auth::login($user);

        // Migrate cart from session to database
        $sessionCart = session('cart', []);
        if (!empty($sessionCart)) {
            foreach ($sessionCart as $productId => $item) {
                $existingCartItem = CartItem::where('user_id', Auth::id())
                    ->where('product_id', $productId)
                    ->first();

                if ($existingCartItem) {
                    // If product already in cart, add quantities
                    $existingCartItem->quantity += $item['quantity'];
                    $existingCartItem->save();
                } else {
                    // Add new item to cart
                    CartItem::create([
                        'user_id' => Auth::id(),
                        'product_id' => $productId,
                        'quantity' => $item['quantity']
                    ]);
                }
            }
            // Clear session cart after migration
            session()->forget('cart');
        }

        toastr()->success('Kích hoạt tài khoản thành công! Chào mừng bạn!');

        return redirect()->route('home');
    }



    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            if (Auth::user()->status !== 'active') {
                Auth::logout();
                toastr()->error('Tài khoản chưa được kích hoạt. Vui lòng kiểm tra email.');
                return back();
            }

            // Migrate cart from session to database
            $sessionCart = session('cart', []);
            if (!empty($sessionCart)) {
                foreach ($sessionCart as $productId => $item) {
                    $existingCartItem = CartItem::where('user_id', Auth::id())
                        ->where('product_id', $productId)
                        ->first();

                    if ($existingCartItem) {
                        // If product already in cart, add quantities
                        $existingCartItem->quantity += $item['quantity'];
                        $existingCartItem->save();
                    } else {
                        // Add new item to cart
                        CartItem::create([
                            'user_id' => Auth::id(),
                            'product_id' => $productId,
                            'quantity' => $item['quantity']
                        ]);
                    }
                }
                // Clear session cart after migration
                session()->forget('cart');
            }

            toastr()->success('Đăng nhập thành công!');
            return redirect()->intended('/');
        }

        //Xử lý nếu đăng nhập thất bại
        return back()->withErrors([
            'email' => 'Email hoặc mật khẩu không đúng.',
        ])->onlyInput('email');
    }


    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        toastr()->success('Đăng xuất thành công!');
        return redirect()->route('home');
    }
}
