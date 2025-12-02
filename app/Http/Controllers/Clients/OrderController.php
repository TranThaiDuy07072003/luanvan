<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

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

        foreach($order->orderItems as $item)
        {
            $item->product->increment('stock', $item->quantity);
        }

        // Cập nhật trạng thái đơn hàng thành "canceled"
        $order->update(['status' => 'canceled']);
        return redirect()->back()->with('success', 'Đơn hàng đã được hủy thành công.');
    }







}
