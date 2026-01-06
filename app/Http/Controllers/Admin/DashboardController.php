<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {

        $users = User::where('role_id', 3)->latest()->get();
        $categories = Category::with('products')->get();
        $products = Product::where('stock', '>', 0)->get();

        //Lấy 3 đơn hàng mới nhất
        $orders = Order::with('shippingAddress')->latest()->take(3)->get();


        // A. Tổng số đơn hàng (chỉ tính đơn không bị hủy)
        $totalOrdersCount = Order::where('status', '!=', 'canceled')->count();

        // B. Tổng doanh thu (tính đơn đã hoàn thành)
        $totalRevenueReal = Order::where('status', 'completed')->sum('total_price');


        //lấy 3 sản phẩm bán chạy
        $topSellingProducts = Product::withCount(['orderItems as total_sold' => function ($query) {
            $query->select(DB::raw('SUM(quantity)'))
                ->whereHas('order', function ($q) {
                    $q->where('status', 'completed');
                });
        }])->orderByDesc('total_sold')->take(3)->get();


        // biểu đồ doanh thu
        $monthlyRevenue = Order::where('status', 'completed')
            ->select(
                DB::raw('SUM(total_price) as revenue'),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
            )
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();


        return view('admin.pages.dashboard', compact(
            'users',
            'categories',
            'products',
            'orders',
            'topSellingProducts',
            'monthlyRevenue',
            'totalOrdersCount',
            'totalRevenueReal'
        ));
    }
}
