<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function showOrder($id)
    {
        // Logic để hiển thị chi tiết đơn hàng dựa trên $id
        // Ví dụ: Lấy thông tin đơn hàng từ cơ sở dữ liệu và trả về view tương ứng
        $order = Order::with(['orderItems.product', 'user', 'shippingAddress', 'payment'])->findOrFail($id);

        $userId = auth()->id();

        return view('user.pages.order-detail', compact('order', 'userId'));
    }

    public function cancel($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->firstOrFail();

        foreach ($order->orderItems as $item) {
            // Hoàn trả lại số lượng tồn kho cho sản phẩm
            $item->product->increment('stock', $item->quantity);
        }

        // Cập nhật trạng thái đơn hàng thành "canceled"
        $order->update(['status' => 'canceled']);

        return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');
    }



    public function completeOrder($id)
    {
        $order = Order::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Chỉ cho phép hoàn thành nếu đơn hàng đang ở trạng thái 'processing' (Đang giao hàng)
        if ($order->status == 'processing') {
            $order->status = 'completed';
            $order->save();

            // (Tùy chọn) Cập nhật luôn trạng thái thanh toán thành 'paid' nếu chưa
            if ($order->payment && $order->payment->status != 'completed') {
                $order->payment->status = 'completed';
                $order->payment->paid_at = now();
                $order->payment->save();
            }

            toastr()->success('Cảm ơn bạn đã mua hàng! Đơn hàng đã hoàn tất.');
        } else {
            toastr()->error('Không thể thực hiện thao tác này.');
        }

        return redirect()->back();
    }



}
