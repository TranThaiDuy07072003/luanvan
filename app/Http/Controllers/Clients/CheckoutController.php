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
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;



class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cartItems = CartItem::with('product')->where('user_id', $user->id)->get();

        // Check tồn kho
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

        // --- SỬA ĐOẠN NÀY: Tính phí ship ngay lần đầu tải trang ---
        // Gọi hàm tính phí cho địa chỉ mặc định
        $shippingData = $this->calculateShippingFee($defaultAddress->id);
        $shippingFee = $shippingData['fee'];
        $distance = $shippingData['distance']; // Lấy thêm khoảng cách để hiển thị

        return view('user.pages.checkout', compact(
            'addresses',
            'defaultAddress',
            'cartItems',
            'cartTotal',
            'hasError',
            'shippingFee', // Truyền biến này sang View
            'distance'     // Truyền biến này sang View
        ));

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

    // hàm xử lý đặt hàng
    public function placeOrder(Request $request)
    {
        $user = Auth::user();
        $cartItems = CartItem::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng trống.');
        }

        DB::beginTransaction();
        try {
            // 1. Tạo đơn hàng chung cho COD và VNPay
            $order = new Order;
            $order->user_id = $user->id;
            $order->shipping_address_id = $request->address_id;
            // Tính lại phí ship chính xác
            $shippingData = $this->calculateShippingFee($request->address_id);
            $finalShippingFee = $shippingData['fee'];

            $order->total_price = $cartItems->sum(fn ($item) => $item->quantity * $item->product->price) + $finalShippingFee;

            // Mặc định là pending (chưa xử lý/chưa thanh toán)
            $order->status = 'pending';
            $order->save();

            // 2. Lưu chi tiết đơn hàng & Trừ kho (phòng thủ)
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

    // tạo hàm url VNPay
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

    // HÀM XỬ LÝ KHI KHÁCH QUAY VỀ TỪ VNPAY
    public function vnpayReturn(Request $request)
    {

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

    // --- HÀM TÍNH PHÍ SHIP TỰ ĐỘNG (Dùng chung cho cả Ajax và Submit) ---
    // --- HÀM TÍNH PHÍ SHIP THÔNG MINH (Có thử lại nếu không tìm thấy) ---
    // --- HÀM TÍNH PHÍ SHIP (BỎ QUA SỐ NHÀ - CHỈ TÍNH TỪ PHƯỜNG/XÃ) ---
    // --- HÀM TÍNH PHÍ SHIP (LOGIC MỚI: BỎ SỐ NHÀ ĐỂ TÌM CHO DỄ) ---
    private function calculateShippingFee($addressId)
    {
        $address = ShippingAddress::find($addressId);
        if (! $address) {
            return ['fee' => 30000, 'distance' => 0];
        }

        $apiKey = env('TRACK_ASIA_KEY');
        $url = 'https://nominatim.openstreetmap.org/search';

        // Dữ liệu từ form 3 cấp lưu vào DB có dạng: "Số nhà, Phường, Quận"
        // Ví dụ: "127/A, Phường 1, Thành phố Cà Mau"
        // City: "Tỉnh Cà Mau"

        $parts = explode(',', $address->address);
        $geoQuery = '';

        // CHIẾN THUẬT: Chỉ lấy (Phường + Quận + Tỉnh) để tìm kiếm
        // Bỏ qua "Số nhà" vì API bản đồ thường không tìm thấy số nhà ở tỉnh lẻ -> Gây lỗi
        if (count($parts) >= 2) {
            // Lấy phần tử cuối (Quận) và kế cuối (Phường)
            $quan = trim(end($parts));
            $phuong = trim(prev($parts));
            $tinh = $address->city;

            // Tạo chuỗi tìm kiếm: "Phường 1, Thành phố Cà Mau, Tỉnh Cà Mau, Việt Nam"
            $geoQuery = "{$phuong}, {$quan}, {$tinh}, Việt Nam";
        } else {
            // Nếu địa chỉ nhập linh tinh, tìm theo Tỉnh
            $geoQuery = $address->city.', Việt Nam';
        }

        try {
            // Gọi API
            $coords = $this->callGeoApi($url, $geoQuery, $apiKey);

            // Nếu không tìm thấy Phường -> Thử tìm theo Quận + Tỉnh
            if (! $coords && isset($quan)) {
                $geoQueryBackup = "{$quan}, {$tinh}, Việt Nam";
                $coords = $this->callGeoApi($url, $geoQueryBackup, $apiKey);
            }

            // Nếu có tọa độ -> Tính tiền
            if ($coords) {
                $lonTo = $coords[0];
                $latTo = $coords[1];
                $latFrom = env('STORE_LAT');
                $lonFrom = env('STORE_LNG');

                // Công thức Haversine (Tính khoảng cách)
                $earthRadius = 6371;
                $dLat = deg2rad($latTo - $latFrom);
                $dLon = deg2rad($lonTo - $lonFrom);
                $a = sin($dLat / 2) * sin($dLat / 2) + cos(deg2rad($latFrom)) * cos(deg2rad($latTo)) * sin($dLon / 2) * sin($dLon / 2);
                $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

                $distance = round($earthRadius * $c, 1); // Km

                // Tính tiền: 5.000đ/km
                $pricePerKm = env('SHIPPING_COST_PER_KM', 5000);
                $fee = $distance * $pricePerKm;

                if ($fee < 30000) {
                    $fee = 30000;
                } // Tối thiểu 30k


                return ['fee' => $fee, 'distance' => $distance];
            }

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Lỗi tính phí: '.$e->getMessage());
        }
        //  \Illuminate\Support\Facades\Log::info('Khoảng cách: ' . $distance);


        return ['fee' => 30000, 'distance' => 0];
    }

    // Hàm phụ gọi API để code gọn hơn
    // Hàm gọi API (Giữ nguyên)
    private function callGeoApi($url, $query, $apiKey = null)
    {
        // Nominatim dùng param 'q' thay vì 'text', và cần format='json'
        $params = [
            'q' => $query,
            'format' => 'json',
            'limit' => 1,
            'addressdetails' => 1,
        ];

        // Nếu dùng TrackAsia thì giữ nguyên logic cũ
        if (strpos($url, 'track-asia') !== false) {
            $params = ['text' => $query, 'key' => $apiKey];
        }

        $response = Http::withHeaders([
            'User-Agent' => 'LaravelApp/1.0', // Nominatim yêu cầu User-Agent
        ])->withoutVerifying() // ← THÊM DÒNG NÀY để bỏ qua SSL check
            ->timeout(10)
            ->get($url, $params);

        if ($response->successful() && count($response->json()) > 0) {
            $data = $response->json();
            // Nominatim trả về mảng trực tiếp, TrackAsia trả về features
            if (isset($data['features'])) {
                return $data['features'][0]['geometry']['coordinates']; // TrackAsia
            } else {
                return [$data[0]['lon'], $data[0]['lat']]; // Nominatim
            }
        }

        return null;
    }

    // --- API CHO AJAX GỌI ---
    public function getShippingFee(Request $request)
    {
        $data = $this->calculateShippingFee($request->address_id);

        $user = Auth::user();
        $cartTotal = CartItem::where('user_id', $user->id)->get()->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });

        return response()->json([
            'success' => true,
            'fee' => $data['fee'], // <--- QUAN TRỌNG: Phải trả về số nguyên để JS cộng trừ
            'fee_formatted' => number_format($data['fee'], 0, ',', '.').' VNĐ',
            'grand_total' => number_format($cartTotal + $data['fee'], 0, ',', '.').' VNĐ',
            'distance_text' => $data['distance'] > 0 ? '(Khoảng cách: '.$data['distance'].' km)' : '',
        ]);
    }
}
