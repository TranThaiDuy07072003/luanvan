<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function showFormAddCate()
    {
        return view('admin.pages.categories-add');
    }



    public function addCategory(Request $request)
    {
        // 1. VALIDATION "CỨNG" (Giống addProduct)
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name', // <--- QUAN TRỌNG: Chặn trùng tên
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // <--- QUAN TRỌNG: Bắt buộc có ảnh và đúng định dạng
        ], [
            // Thông báo lỗi tiếng Việt thân thiện
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'name.unique' => 'Tên danh mục này đã tồn tại, vui lòng chọn tên khác.',
            'name.max' => 'Tên danh mục không được quá 255 ký tự.',

            'image.required' => 'Vui lòng chọn hình ảnh đại diện cho danh mục.',
            'image.image' => 'File tải lên phải là hình ảnh.',
            'image.mimes' => 'Ảnh phải có đuôi: jpeg, png, jpg, gif, svg.',
            'image.max' => 'Dung lượng ảnh không được quá 2MB.',
        ]);

        // 2. TẠO SLUG
        $slug = Str::slug($request->name);
        // Lưu ý: Danh mục thường cần URL đẹp nên mình không nối thêm time() như sản phẩm,
        // vì đã có validate unique ở trên chặn trùng rồi.

        // 3. XỬ LÝ ẢNH (Tối ưu hóa dung lượng như Product)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = 'uploads/categories/' . $fileName;

            // Resize ảnh danh mục cho nhẹ (ví dụ 300x300 hoặc tùy ý bạn)
            // Cần use Intervention\Image\Facades\Image; ở đầu file
            $resizedImage = Image::make($file)
                            ->resize(300, 300, function ($constraint) {
                                $constraint->aspectRatio(); // Giữ tỉ lệ ảnh
                                $constraint->upsize();      // Không phóng to nếu ảnh nhỏ
                            })->encode();

            Storage::disk('public')->put($path, $resizedImage);
            $imagePath = $path;
        }

        // 4. LƯU VÀO DATABASE
        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.categories.add')->with('success', 'Danh mục đã được thêm thành công!');
    }




    public function index()
    {
        // withCount('products'): Laravel sẽ tự đếm số sản phẩm và thêm cột 'products_count' vào kết quả.
        // Cách này cực nhanh, chỉ tốn 1 câu lệnh SQL.
        $categories = Category::withCount('products')->get();

        return view('admin.pages.categories', compact('categories'));
    }




    public function updateCategory(Request $request)
    {
        try {
            $category = Category::findOrFail($request->category_id);
            if(!$category) {
                return response()->json([
                    'status' => false,
                    'message' => 'Danh mục không tồn tại!'
                ], 404);
            }

            $category->name = $request->name;
            $category->description = $request->description;

            if($request->hasFile("image")){
                if($category->image) {
                    // xóa ảnh cũ
                    Storage::disk('public')->delete($category->image);
                }

                $imagePath = $request->file("image");
                $fileName = now()->timestamp.'_'.uniqid().'.'.$imagePath->getClientOriginalExtension();
                $imagePath = $imagePath->storeAs('uploads/categories', $fileName, 'public');

                $category->image = $imagePath;
            }
            $category->save();

            return response()->json([
                'status' => true,
                'message' => 'Cập nhật danh mục thành công!',
                'data' => [
                    'id' => $category->id,
                    'name' => $category->name,
                    'slug' => $category->slug,
                    'description' => $category->description,
                    'image' => $category->image ? asset('storage/' . $category->image) : null,
                ]
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi khi cập nhật danh mục.'
            ], 500);
        }
    }



    public function deleteCategory(Request $request)
    {
        try {
            $category = Category::findOrFail($request->category_id);

            if(!$category) {
                return response()->json([
                    'status' => false,
                    'message' => 'Danh mục không tồn tại!'
                ], 404);
            }

            // Đếm số sản phẩm đang thuộc danh mục này
            $productCount = $category->products()->count();

            if ($productCount > 0) {
                // Nếu còn sản phẩm -> Trả về lỗi, KHÔNG XÓA
                return response()->json([
                    'status' => false,
                    'message' => 'Không thể xóa! Danh mục này đang chứa ' . $productCount . ' sản phẩm. Vui lòng xóa hết sản phẩm trong danh mục này trước.'
                ]);
            }

            // Nếu không còn sản phẩm (số lượng = 0) thì mới chạy xuống đây để xóa

            // Xóa ảnh cũ của danh mục (nếu có)
            if($category->image) {
                // Kiểm tra file tồn tại trước khi xóa
                if(Storage::disk('public')->exists($category->image)){
                    Storage::disk('public')->delete($category->image);
                }
            }

            $category->delete();

            return response()->json([
                'status' => true,
                'message' => 'Xóa danh mục thành công!'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Đã xảy ra lỗi khi xóa danh mục: ' . $th->getMessage()
            ], 500);
        }
    }






    // Viết xuống cuối file CategoryController.php
    public function demoStore(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required'
        ]);


        if ($request->hasFile('image')) {
            $file = $request->file('image');

            $fileName = time() . '_' . $file->getClientOriginalName();

            $imagePath = $file->storeAs('uploads/categories', $fileName, 'public');
        }

        $slug = Str::slug($request->name);

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'image' => $imagePath
        ]);

        return "Thêm danh mục: " . $request->name . " thành công! (Dữ liệu đã vào DB thật)";
    }




}
