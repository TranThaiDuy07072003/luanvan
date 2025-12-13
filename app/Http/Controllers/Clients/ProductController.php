<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // File: ProductController.php

    public function index(Request $request) // Nhớ thêm Request $request vào
    {
        $categories = Category::withCount('products')->get();

        // Thêm withQueryString để giữ tham số trên URL
        $products = Product::with('firstImage')
            ->whereIn('status', ['in_stock', 'out_of_stock'])
            ->paginate(9)
            ->withQueryString();

        // Xử lý ảnh (code cũ của bạn)
        foreach ($products as $product) {
            $product->image_url = $product->firstImage?->image
                ? asset('storage/'.$product->firstImage->image)
                : asset('storage/uploads/products/default-product.png');
        }

        // --- ĐOẠN MỚI THÊM VÀO ---
        // Kiểm tra nếu là AJAX (bấm phân trang) thì trả về JSON
        if ($request->ajax()) {
            return response()->json([
                'products_html' => view('user.components.products_grid', compact('products'))->render(),
                'pagination_html' => $products->links('user.components.pagination.pagination_custom')->toHtml(),
            ]);
        }
        // -------------------------

        return view('user.pages.products', compact('categories', 'products'));
    }

    public function filter(Request $request)
    {
        $query = Product::with('firstImage')->whereIn('status', ['in_stock', 'out_of_stock']);

        // Lọc Category
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('sort_by')) {
            switch ($request->sort_by) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'latest':
                    $query->orderBy('created_at', 'desc');
                    break;
                default:
                    $query->orderBy('id', 'desc');
                    break;
            }
        } else {

            $query->orderBy('id', 'desc');
        }

        $products = $query->paginate(9)->withQueryString();

        /** @var \App\Models\Product $product */
        foreach ($products as $product) {
            $product->image_url = $product->firstImage?->image
            ? asset('storage/'.$product->firstImage->image)
                : asset('storage/uploads/products/default-product.png');
        }

        // SỬA LẠI: Trả về 2 key (products_html và pagination_html)
        return response()->json([
            'products_html' => view('user.components.products_grid', compact('products'))->render(),
            // SỬA: Chỉ định rõ file custom pagination
            'pagination_html' => $products->links('user.components.pagination.pagination_custom')->toHtml(),
        ]);

    }

    public function filterByCategory($id)
    {
        $categories = Category::withCount('products')->get();
        $selectedCategory = Category::findOrFail($id);

        $products = Product::with('firstImage')
            ->where('category_id', $id)
            ->whereIn('status', ['in_stock', 'out_of_stock'])
            ->paginate(9);

        /** @var \App\Models\Product $product */
        foreach ($products as $product) {
            $product->image_url = $product->firstImage?->image
                ? asset('storage/'.$product->firstImage->image)
                : asset('storage/uploads/products/default-product.png');
        }

        return view('user.pages.products', compact('categories', 'products', 'selectedCategory'));
    }

    public function detail($slug)
    {
        $product = Product::with(['category', 'images', 'reviews.user'])->where('slug', $slug)->firstOrFail();

        // lấy sản phẩm cùng danh mục
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(6)
            ->get();

        // tính điểm đánh giá trung bình
        $averageRating = round($product->reviews()->avg('rating') ?? 0, 1);

        $hasPurchased = false;
        $hasReviewed = false;

        if (Auth::check()) {
            $user = Auth::user();

            // Kiểm tra người dùng đã mua sản phẩm hay chưa
            $hasPurchased = OrderItem::whereHas('order', function ($query) use ($user) {
                $query->where('user_id', $user->id)->where('status', 'completed');
            })->where('product_id', $product->id)->exists();

            // Kiểm tra người dùng đã danh giá sản phẩm hay chưa
            $hasReviewed = Review::where('user_id', $user->id)
                ->where('product_id', $product->id)
                ->exists();
        }

        // 2. [QUAN TRỌNG] Xử lý đường dẫn ảnh cho sản phẩm tương tự
        foreach ($relatedProducts as $related) {
            $related->image_url = $related->firstImage
                ? asset('storage/'.$related->firstImage->image)
                : asset('storage/uploads/products/default-product.png');
        }

        return view('user.pages.product-detail', compact('product', 'relatedProducts', 'hasPurchased', 'hasReviewed', 'averageRating'));
    }
}
