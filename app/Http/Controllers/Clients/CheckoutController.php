<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\ShippingAddress;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // --- LOGIC KIỂM TRA SẢN PHẨM TRƯỚC KHI VÀO CHECKOUT (MỚI) ---
        // Lấy giỏ hàng từ Session hoặc DB (tùy logic getCart của bạn)
        // Ở đây mình giả sử bạn có cách lấy cartItems giống như bên CartController
        // Nếu bạn dùng Cart Service hay Helper thì gọi ra nhé.
        // Dưới đây là ví dụ check thủ công từ DB (dành cho user đã login):

        $cartItems = \App\Models\CartItem::where('user_id', $user->id)->get(); // Hoặc lấy từ Session nếu chưa login

        foreach ($cartItems as $item) {
            $product = $item->product; // Relation product

            // 1. Check trạng thái
            if (! $product || $product->status == 'out_of_stock') {
                toastr()->error('Sản phẩm "'.($product->name ?? 'Không xác định').'" đã hết hàng. Vui lòng kiểm tra lại giỏ hàng.');

                return redirect()->route('cart.index');
            }

            // 2. Check số lượng tồn
            if ($product->stock < $item->quantity) {
                toastr()->error('Sản phẩm "'.$product->name.'" không đủ số lượng trong kho. Vui lòng kiểm tra lại.');

                return redirect()->route('cart.index');
            }
        }
        // -------------------------------------------------------------

        $addresses = ShippingAddress::where('user_id', $user->id)->get();
        $defaultAddress = $addresses->where('default', 1)->first();

        if ($addresses->isEmpty() || is_null($defaultAddress)) {
            toastr()->error('Vui lòng thêm địa chỉ giao hàng !');

            return redirect()->route('account');
        }

        return view('user.pages.checkout', compact('addresses', 'defaultAddress'));
    }
}
