<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::with('products')->get();
        foreach ($categories as $index => $category) {
            foreach ($category->products as $product) {
                $product->image_url = $product->firstImage?->image
                ? asset('storage/uploads/products/'.$product->firstImage->image) : asset('storage/uploads/products/default-product.png');
            }
        }


        // Tải thêm 'firstImage' để lấy ảnh
        $bestSellingProducts = Product::with('firstImage')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->select('products.*') // Chọn tất cả cột từ bảng products
            ->selectRaw('SUM(order_items.quantity) as total_sold')
            // Đơn giản hóa Group By, chỉ cần group by ID của product
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->limit(10)
            ->get();

        // SỬA LỖI 2: Thêm image_url cho sản phẩm bán chạy
        /** @var \App\Models\Product $product */
        foreach ($bestSellingProducts as $product) {
             $product->image_url = $product->firstImage?->image
                ? asset('storage/uploads/products/'.$product->firstImage->image) : asset('storage/uploads/products/default-product.png');
        }

        return view('user.pages.home', compact('categories', 'bestSellingProducts'));
    }
}
