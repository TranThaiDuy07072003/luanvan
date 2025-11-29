<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function showFormAddProduct()
    {
        $categories = Category::all();

        return view('admin.pages.product-add', compact('categories'));
    }

    public function addProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',

            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $slug = Str::slug($request->name).'-'.time();

        // Create product

        $product = Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
            'unit' => $request->unit ?? 'kg',
            'status' => 'in_stock',
        ]);

        // Handle images upload

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
                $path = 'uploads/products/'.$imageName;

                $resizedImage = Image::make($image)->resize(600, 600)->encode();

                Storage::disk('public')->put($path, $resizedImage);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                ]);
            }
        }

        return redirect()->route('admin.product.add')->with('success', 'Sản phẩm đã được thêm thành công!');
    }

    // public function index()
    // {
    //     $products = Product::with('category', 'images')->get();
    //     return view('admin.pages.products', compact('products'));
    // }

    // Nhớ import Request nếu chưa có: use Illuminate\Http\Request;

    public function index(Request $request)
    {
        // 1. Khởi tạo Query (Chưa lấy dữ liệu vội)
        $query = Product::with(['category', 'firstImage'])->orderBy('id', 'desc');

        // 2. Kiểm tra nếu có lọc Danh mục
        if ($request->has('category_id') && $request->category_id != null) {
            $query->where('category_id', $request->category_id);
        }

        // 3. Kiểm tra nếu có lọc Trạng thái (Làm thêm cho xịn)
        if ($request->has('status') && $request->status != null) {
            $query->where('status', $request->status);
        }

        // 4. Lấy dữ liệu (Lúc này mới chạy câu lệnh SQL)
        $products = $query->get();

        // 5. Xử lý ảnh (Logic cũ của bạn)
        foreach ($products as $product) {
            if ($product->firstImage) {
                $product->image_url = asset('storage/'.$product->firstImage->image);
            } else {
                $product->image_url = asset('storage/uploads/products/default-product.png');
            }
        }

        $categories = Category::all();

        // 6. Trả về View
        return view('admin.pages.products', compact('products', 'categories'));
    }




    public function updateProduct(Request $request)
    {
        // 1. Validate
        $request->validate([
            'id' => 'required|exists:products,id',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:in_stock,out_of_stock', // Thêm validate cho status
        ]);

        $product = Product::findOrFail($request->id);

        $newStatus = $request->status; // Lấy cái Admin đang chọn trong ô Select

        // Chỉ can thiệp tự động trong 1 trường hợp duy nhất:
        // Nếu kho thực sự hết hàng (<=0) thì dù Admin chọn "Còn hàng" cũng phải ép về "Hết hàng"
        if ($request->stock <= 0) {
            $newStatus = 'out_of_stock';
        }


        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
            'unit' => $request->unit ?? 'kg',
            'status' => $newStatus, // Lưu trạng thái chốt hạ
        ]);


        if ($request->hasFile('images')) {

            $oldImages = ProductImage::where('product_id', $product->id)->get();
            foreach ($oldImages as $image) {
                if (Storage::disk('public')->exists($image->image)) {
                    Storage::disk('public')->delete($image->image);
                }
            }

            ProductImage::where('product_id', $product->id)->delete();

            foreach ($request->file('images') as $image) {

                $imageName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
                $path = 'uploads/products/'.$imageName;
                $resizedImage = Image::make($image)->resize(600, 600)->encode();
                Storage::disk('public')->put($path, $resizedImage);

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $path,
                ]);
            }
        }

        //Trả về dữ liệu mới nhất cho Client
        $product->load('category', 'images');
        $firstImage = $product->images->first();
        $imageUrl = $firstImage ? asset('storage/'.$firstImage->image) : asset('storage/uploads/products/default-product.png');

        return response()->json([
            'status' => true,
            'message' => 'Cập nhật sản phẩm thành công.',
            'data' => [
                'id' => $product->id,
                'name' => $product->name,
                'slug' => $product->slug,
                'category' => [
                    'name' => $product->category->name
                ],
                'description' => $product->description,
                'price' => $product->price,
                'price_formatted' => number_format($product->price, 0, ',', '.'),
                'stock' => $product->stock,
                'unit' => $product->unit,
                'status' => $product->status == 'in_stock' ? 'Còn hàng' : 'Hết hàng',
                'image_url' => $imageUrl,
            ],
        ]);
    }





    public function deleteProduct(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->id);

        // --- RÀNG BUỘC NGHIỆP VỤ MỚI ---
        if ($product->status == 'in_stock') {
            return response()->json([
                'status' => false,
                'message' => 'Không thể xóa! Sản phẩm đang trạng thái "Còn hàng". Vui lòng chuyển sang "Hết hàng" trước khi xóa.'
            ]);
        }


        $images = ProductImage::where('product_id', $product->id)->get();
        foreach ($images as $image) {
            if (Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
        }

        ProductImage::where('product_id', $product->id)->delete();

        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sản phẩm đã được xóa thành công.',
        ]);
    }


}
