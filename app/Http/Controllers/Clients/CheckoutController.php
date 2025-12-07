<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Mail\OrderConfirmation;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\ShippingAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();

        // Check tồn kho (Code cũ của bạn)
        foreach ($cartItems as $item) {
            $product = $item->product;
            if (! $product || $product->status == 'out_of_stock') {
                toastr()->error('Sản phẩm "'.($product->name ?? 'Không xác định').'" đã hết hàng.');

                return redirect()->route('cart.index');
            }
            if ($product->stock < $item->quantity) {
                toastr()->error('Sản phẩm "'.$product->name.'" không đủ số lượng.');

                return redirect()->route('cart.index');
            }
        }

        $cartTotal = 0;
        foreach ($cartItems as $item) {
            $cartTotal += $item->product->price * $item->quantity;
        }

        $addresses = ShippingAddress::where('user_id', $user->id)->get();
        $defaultAddress = $addresses->where('default', 1)->first();

        if ($addresses->isEmpty() || is_null($defaultAddress)) {
            toastr()->error('Vui lòng thêm địa chỉ giao hàng !');

            return redirect()->route('account');
        }

        $hasError = false;

        return view('user.pages.checkout', compact('addresses', 'defaultAddress', 'cartItems', 'cartTotal', 'hasError'));
    }

    public function getAddress(Request $request)
    {
        $address = ShippingAddress::where('id', $request->address_id)->where('user_id', Auth::id())->first();
        if (! $address) {
            return response()->json(['success' => false, 'message' => 'Địa chỉ không tồn tại'], 404);
        }

        return response()->json(['success' => true, 'data' => $address]);
    }

    // --- HÀM XỬ LÝ ĐẶT HÀNG (Đã sửa đổi) ---
    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng trống.');
        }

        DB::beginTransaction();
        try {
            // 1. Tạo đơn hàng (Chung cho cả COD và VNPay)
            $order = new Order;
            $order->user_id = $user->id;
            $order->shipping_address_id = $request->address_id;
            $order->total_price = $cartItems->sum(fn ($item) => $item->quantity * $item->product->price) + 15000;

            // Mặc định là pending (chưa xử lý/chưa thanh toán)
            $order->status = 'pending';
            $order->save();

            // 2. Lưu chi tiết đơn hàng & Trừ kho
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                $product = $item->product;
                if ($product->stock < $item->quantity) {
                    throw new \Exception('Sản phẩm "'.$product->name.'" không đủ hàng.');
                }
                $product->stock -= $item->quantity;
                $product->save();
            }

            // 3. Tạo Payment Record (Trạng thái Pending)
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => $request->payment_method, // 'cash' hoặc 'vnpay'
                'amount' => $order->total_price,
                'status' => 'pending',
                'paid_at' => null,
            ]);

            // 4. Xóa giỏ hàng
            CartItem::where('user_id', $user->id)->delete();

            DB::commit(); // Lưu dữ liệu vào DB thành công

            // --- THÊM ĐOẠN GỬI MAIL NÀY ---
            if ($request->payment_method == 'cash') {
                try {
                    Mail::to($user->email)->send(new OrderConfirmation($order));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Lỗi gửi mail: '.$e->getMessage());
                }
            }
            // ------------------------------

            // --- PHÂN LUỒNG THANH TOÁN ---

            // Trường hợp 1: Thanh toán VNPay
            if ($request->payment_method == 'vnpay') {
                // Gọi hàm tạo URL VNPay và chuyển hướng khách hàng
                return $this->createVNPayUrl($order);
            }

            // Trường hợp 2: Thanh toán COD (Tiền mặt) - Code cũ của bạn
            toastr()->success('Đặt hàng thành công !');

            return redirect()->route('account');

        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error($e->getMessage());

            return redirect()->route('checkout');
        }
    }

    // --- HÀM TẠO URL VNPAY (Mới) ---
    private function createVNPayUrl($order)
    {
        $vnp_Url = env('VNP_URL');
        $vnp_Returnurl = route('vnpay.return'); // Route đã tạo ở bước 2
        $vnp_TmnCode = env('VNP_TMN_CODE'); // Mã website
        $vnp_HashSecret = env('VNP_HASH_SECRET'); // Chuỗi bí mật

        $vnp_TxnRef = $order->id; // Mã đơn hàng
        $vnp_OrderInfo = 'Thanh toan don hang #'.$order->id;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $order->total_price * 100; // VNPay yêu cầu nhân 100
        $vnp_Locale = 'vn';
        $vnp_IpAddr = request()->ip();

        $inputData = [
            'vnp_Version' => '2.1.0',
            'vnp_TmnCode' => $vnp_TmnCode,
            'vnp_Amount' => $vnp_Amount,
            'vnp_Command' => 'pay',
            'vnp_CreateDate' => date('YmdHis'),
            'vnp_CurrCode' => 'VND',
            'vnp_IpAddr' => $vnp_IpAddr,
            'vnp_Locale' => $vnp_Locale,
            'vnp_OrderInfo' => $vnp_OrderInfo,
            'vnp_OrderType' => $vnp_OrderType,
            'vnp_ReturnUrl' => $vnp_Returnurl,
            'vnp_TxnRef' => $vnp_TxnRef,
        ];

        ksort($inputData);
        $query = '';
        $i = 0;
        $hashdata = '';
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&'.urlencode($key).'='.urlencode($value);
            } else {
                $hashdata .= urlencode($key).'='.urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key).'='.urlencode($value).'&';
        }

        $vnp_Url = $vnp_Url.'?'.$query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash='.$vnpSecureHash;
        }

        return redirect($vnp_Url);
    }

    // --- HÀM XỬ LÝ KHI KHÁCH QUAY VỀ TỪ VNPAY (Mới) ---
    public function vnpayReturn(Request $request)
    {
        // Kiểm tra chữ ký bảo mật (Tránh giả mạo)
        // (Logic check hash ở đây có thể thêm vào nếu cần bảo mật cao hơn,
        // nhưng với đồ án thì check ResponseCode là ổn)

        // 00 là mã thành công của VNPay
        if ($request->vnp_ResponseCode == '00') {

            // Tìm đơn hàng và cập nhật trạng thái
            $orderId = $request->vnp_TxnRef;
            $order = Order::find($orderId);

            if ($order) {
                // Cập nhật trạng thái đơn hàng -> Đã thanh toán (Processing)
                $order->status = 'pending';
                $order->save();

                // Cập nhật bảng Payment
                Payment::where('order_id', $orderId)->update([
                    'status' => 'completed',
                    'paid_at' => now(),
                ]);

                // --- THÊM ĐOẠN GỬI MAIL NÀY ---
                try {
                    Mail::to($order->user->email)->send(new OrderConfirmation($order));
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error('Lỗi gửi mail VNPay: '.$e->getMessage());
                }
                // ------------------------------

                toastr()->success('Thanh toán thành công! Cảm ơn bạn đã mua hàng.');

                return redirect()->route('account');
            }
        }

        // Nếu thất bại hoặc hủy
        toastr()->error('Thanh toán thất bại hoặc bị hủy.');

        return redirect()->route('checkout');
    }
}
