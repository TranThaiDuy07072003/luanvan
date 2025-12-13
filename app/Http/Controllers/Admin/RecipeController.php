<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product; // <--- QUAN TRỌNG: Phải có dòng này mới tìm được sản phẩm
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class RecipeController extends Controller
{
    // 1. Danh sách món ăn
    public function index()
    {
        $recipes = Recipe::withCount('products')->orderByDesc('id')->get();

        return view('admin.pages.recipes.index', compact('recipes'));
    }

    // 2. Form Thêm món ăn
    public function create()
    {
        return view('admin.pages.recipes.create');
    }

    // 3. Xử lý Lưu món ăn
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:recipes,name',
            'image' => 'required|image|max:2048',
            'products' => 'required|array|min:1',
        ], [
            'name.required' => 'Tên món ăn không được để trống.',
            'name.unique' => 'Tên món ăn này đã tồn tại.',
            'image.required' => 'Vui lòng chọn ảnh đại diện món ăn.',
            'products.required' => 'Vui lòng chọn ít nhất 1 nguyên liệu.',
        ]);

        // Lưu ảnh món ăn
        $path = null;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'_'.uniqid().'.'.$image->getClientOriginalExtension();
            // Lưu vào uploads/recipes (Giống cấu trúc product)
            $path = 'uploads/recipes/'.$imageName;

            $resizedImage = Image::make($image)->resize(600, 600)->encode();
            Storage::disk('public')->put($path, $resizedImage);
        }

        $recipe = Recipe::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name).'-'.time(),
            'description' => $request->description,
            'image' => $path,
        ]);

        // Lưu bảng trung gian
        $syncData = [];
        if ($request->products) {
            foreach ($request->products as $index => $productId) {
                // Kiểm tra nếu có sản phẩm mới thêm vào
                if ($productId) {
                    $qty = $request->quantities[$index] ?? 1;
                    $syncData[$productId] = ['quantity' => $qty];
                }
            }
        }

        $recipe->products()->attach($syncData);

        return redirect()->route('admin.recipes.index')->with('success', 'Thêm món ăn thành công!');
    }

    // 4. Ajax tìm kiếm sản phẩm (ĐÃ SỬA LỖI)
    // 4. Ajax tìm kiếm sản phẩm (ĐÃ FIX LỖI DATABASE)
    public function searchProducts(Request $request)
    {
        try {
            $search = $request->term; // Từ khóa gõ vào

            // 1. Bỏ chữ 'image' trong select vì bảng products không có cột này
            // 2. Kèm theo quan hệ 'images' để lấy hình từ bảng phụ
            $products = Product::where('name', 'LIKE', "%{$search}%")
                ->select('id', 'name', 'unit', 'price')
                ->with('images') // Load quan hệ hình ảnh
                ->limit(20)
                ->get();

            $results = [];
            foreach ($products as $product) {
                // Lấy hình ảnh đầu tiên trong mảng images
                $imageUrl = asset('storage/uploads/products/default-product.png'); // Ảnh mặc định

                if ($product->images && $product->images->count() > 0) {
                    // Lấy ảnh đầu tiên tìm thấy
                    $firstImage = $product->images->first();
                    // Đường dẫn trong DB là 'uploads/products/...' nên cần thêm 'storage/'
                    $imageUrl = asset('storage/'.$firstImage->image);
                }

                $results[] = [
                    'id' => $product->id,
                    'text' => $product->name.' ('.number_format($product->price).'đ)',
                    'unit' => $product->unit ?? 'cái',
                    'image' => $imageUrl,
                ];
            }

            return response()->json(['results' => $results]);

        } catch (\Exception $e) {
            return response()->json(['results' => [], 'error' => $e->getMessage()]);
        }
    }



    // Xử lý Xóa món ăn
    public function destroy(Request $request)
    {
        // Tìm món ăn theo ID gửi lên
        $recipe = Recipe::find($request->id);

        if ($recipe) {
            // 1. Xóa ảnh trong folder 'uploads/recipes' nếu có
            if ($recipe->image && Storage::disk('public')->exists($recipe->image)) {
                Storage::disk('public')->delete($recipe->image);
            }

            // 2. Xóa sạch các nguyên liệu liên kết trong bảng trung gian (product_recipes)
            // Nếu không làm bước này, database sẽ bị rác
            $recipe->products()->detach();

            // 3. Xóa món ăn khỏi database
            $recipe->delete();

            return response()->json([
                'status' => true,
                'message' => 'Đã xóa món ăn thành công!'
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Không tìm thấy món ăn này hoặc đã bị xóa.'
        ]);
    }


}
