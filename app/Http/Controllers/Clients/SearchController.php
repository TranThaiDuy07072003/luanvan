<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ràng buộc đầu vào (Validation)
        // Yêu cầu: Phải nhập, tối thiểu 2 ký tự, tối đa 50 ký tự
        $request->validate([
            'keyword' => 'required|string|min:2|max:50',
        ], [
            'keyword.required' => 'Vui lòng nhập từ khóa tìm kiếm.',
            'keyword.min' => 'Từ khóa phải có ít nhất 2 ký tự.',
            'keyword.max' => 'Từ khóa quá dài.',
        ]);

        $keyword = $request->input('keyword');

        // 2. Truy vấn chuẩn nghiệp vụ
        $products = Product::query()
            ->where(function($query) use ($keyword) {
                // Gom nhóm OR để tránh sai sót logic với các điều kiện khác
                $query->where('name', 'LIKE', '%' . $keyword . '%')
                      ->orWhere('description', 'LIKE', '%' . $keyword . '%');
            })
            // Chỉ lấy các trạng thái được phép hiển thị (ví dụ ẩn các bài 'draft')
            ->whereIn('status', ['in_stock', 'out_of_stock'])
            ->with('firstImage') // Eager load để tránh N+1 Query
            ->orderBy('created_at', 'desc') // Sắp xếp sản phẩm mới nhất lên đầu
            ->paginate(8)
            ->withQueryString(); // QUAN TRỌNG: Giữ lại từ khóa ?keyword=abc khi bấm sang trang 2

        // (Đoạn xử lý ảnh thủ công mình đã bỏ đi, hãy dùng Accessor trong Model như hướng dẫn ở cuối bài)
        /** @var \App\Models\Product $product */
        foreach ($products as $product) {
            $product->image_url = $product->firstImage?->image
            ? asset('storage/' . $product->firstImage->image)
                : asset('storage/uploads/products/default-product.png');
        }

        return view('user.pages.products-search', compact('products', 'keyword'));
    }
}
