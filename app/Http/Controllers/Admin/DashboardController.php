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


        //Tổng số đơn hàng (chỉ tính đơn không bị hủy)
        $totalOrdersCount = Order::where('status', '!=', 'canceled')->count();

        //Tổng doanh thu (tính đơn đã hoàn thành)
        $totalRevenueReal = Order::where('status', 'completed')->sum('total_price');


        //lấy 3 sản phẩm bán chạy
        $topSellingProducts = Product::withCount(['orderItems as total_sold' => function ($query) {
            $query->select(DB::raw('SUM(quantity)'))
                ->whereHas('order', function ($q) {
                    $q->where('status', 'completed');
                });
        }])->orderByDesc('total_sold')->take(3)->get();


        $year = request('year', now()->year);


        // biểu đồ doanh thu
        $rawRevenue = Order::where('status', 'completed')
            ->whereYear('created_at', $year)
            ->select(
                DB::raw('SUM(total_price) as revenue'),
                DB::raw('MONTH(created_at) as month')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        
        // Tạo một bộ khung từ 1 đến 12
        $monthlyRevenue = collect(range(1, 12))->map(function ($month) use ($rawRevenue) {
            // Tìm xem tháng này có trong dữ liệu DB không
            $found = $rawRevenue->firstWhere('month', $month);

            return [
                'month' => $month,
                'revenue' => $found ? $found->revenue : 0, // Có thì lấy tiền, không thì bằng 0
            ];
        });


        return view('admin.pages.dashboard', compact(
            'users',
            'categories',
            'products',
            'orders',
            'topSellingProducts',
            'monthlyRevenue',
            'totalOrdersCount',
            'totalRevenueReal',
            'year'
        ));
    }
}
