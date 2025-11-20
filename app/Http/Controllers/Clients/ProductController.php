<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->get();
        $products = Product::with('firstImage')->where('status', 'in_stock')->paginate(9);


        /** @var \App\Models\Product $product */
        foreach ($products as $product) {
            $product->image_url = $product->firstImage?->image
            ? asset('storage/uploads/products/'.$product->firstImage->image) : asset('storage/uploads/products/default-product.png');
        }

        return view('user.pages.products', compact('categories', 'products'));
    }





    public function filter(Request $request){
        $query = Product::with('firstImage')->where('status', 'in_stock');

        // Lọc Category
        if($request->has('category_id')&& $request->category_id != '')
        {
            $query->where('category_id', $request->category_id);
        }

        // Lọc Sắp xếp
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
            // Thêm else để luôn có sắp xếp mặc định
             $query->orderBy('id', 'desc');
        }

        // Thêm withQueryString() để giữ các tham số filter khi click link phân trang
        $products = $query->paginate(9)->withQueryString();

        /** @var \App\Models\Product $product */
        foreach ($products as $product) {
            $product->image_url = $product->firstImage?->image
            ? asset('storage/uploads/products/'.$product->firstImage->image) : asset('storage/uploads/products/default-product.png');
        }

        // SỬA LẠI: Trả về 2 key (products_html và pagination_html)
        return response()->json([
            'products_html' => view('user.components.products_grid', compact('products'))->render(),
            // SỬA: Chỉ định rõ file custom pagination
            'pagination_html' => $products->links('user.components.pagination.pagination_custom')->toHtml(),
        ]);

    }



    public function detail($slug)
    {
        $product = Product::with( ['category', 'images'])->where( 'slug',  $slug)->firstOrFail();

        // Get products in the same category
        $relatedProducts = Product::where( 'category_id',  $product->category_id)
        ->where('id',  '!=',  $product->id)
        ->limit( 6)
        ->get();

        return view('user.pages.product-detail',  compact('product',  'relatedProducts'));
    }





}
