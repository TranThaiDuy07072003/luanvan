<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // <--- SỬA THÀNH CÁI NÀY (Http\Request)
use Illuminate\Support\Facades\DB;

use function Flasher\Toastr\Prime\toastr;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Lấy giỏ hàng (Kèm theo thông tin Product để hiển thị tên, giá...)
        // Sử dụng 'with' để load quan hệ product giúp query nhanh hơn
        $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();

        // --- LOGIC KIỂM TRA SẢN PHẨM (Code cũ của bạn giữ nguyên) ---
        foreach ($cartItems as $item) {
            $product = $item->product;

            if (! $product || $product->status == 'out_of_stock') {
                toastr()->error('Sản phẩm "'.($product->name ?? 'Không xác định').'" đã hết hàng. Vui lòng kiểm tra lại giỏ hàng.');

                return redirect()->route('cart.index');
            }

            if ($product->stock < $item->quantity) {
                toastr()->error('Sản phẩm "'.$product->name.'" không đủ số lượng trong kho. Vui lòng kiểm tra lại.');

                return redirect()->route('cart.index');
            }
        }
        // -------------------------------------------------------------

        // 2. Tính tổng tiền ($cartTotal) để hiển thị bên View
        $cartTotal = 0;
        foreach ($cartItems as $item) {
            // Giả sử giá nằm ở bảng product và tên cột là 'price' hoặc 'sale_price'
            // Bạn hãy sửa lại 'price' cho đúng với tên cột trong DB của bạn
            $price = $item->product->price;
            $cartTotal += $price * $item->quantity;
        }

        // 3. Xử lý địa chỉ (Code cũ của bạn)
        $addresses = ShippingAddress::where('user_id', $user->id)->get();
        $defaultAddress = $addresses->where('default', 1)->first();

        if ($addresses->isEmpty() || is_null($defaultAddress)) {
            toastr()->error('Vui lòng thêm địa chỉ giao hàng !');

            return redirect()->route('account');
        }

        // 4. Biến hasError (Trong view bạn có dùng để disable nút đặt hàng)
        // Vì nếu có lỗi ở trên mình đã redirect rồi, nên xuống đây mặc định là false
        $hasError = false;

        // QUAN TRỌNG: Phải truyền cartItems, cartTotal, hasError vào compact
        return view('user.pages.checkout', compact('addresses', 'defaultAddress', 'cartItems', 'cartTotal', 'hasError'));
    }



    public function getAddress(Request $request)
    {

        $address = ShippingAddress::where('id', $request->address_id)
            ->where('user_id', Auth::id())->first();

        if (! $address) {
            return response()->json(['success' => false, 'message' => 'Địa chỉ không tồn tại'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $address,
        ]);

    }




    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty())
        {
            return redirect()->route('cart')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        DB::beginTransaction();

        try{
            $order = new Order();
            $order->user_id = $user->id;
            $order->shipping_address_id = $request->address_id;
            $order->total_price = $cartItems->sum(fn($item) => $item->quantity * $item->product->price) + 15000;
            $order->status = 'pending';
            $order->save();

            foreach($cartItems as $item)
            {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);
            }
            // Create payment
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method,
                'amount' => $order->total_price,
                'status' => 'pending',
                'paid_at' => null,
            ]);

            // delete product in cart when ordered
            CartItem::where('user_id', $user->id)->delete();
            DB::commit();
            toastr()->success('Đặt hàng thành công !');
            return redirect()->route('account');


        } catch(\Exception $e){
            toastr()->error('Đặt hàng thất bại. Vui lòng thử lại sau.');
            return redirect()->route('checkout');
        }
    }


}
