<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage; // <-- Nhớ use Model ProductImage


class Product extends Model
{
    use HasFactory;


    protected $fillable = ['name', 'description', 'price', 'stock', 'category_id', 'status', 'slug', 'unit'];


    // 1. Mỗi sản phẩm thuộc về 1 danh mục (Category)
    public function category()
    {
        return $this->belongsTo(Category::class);   // nhánh 2 chân
    }



     // 2. Một sản phẩm có nhiều hình ảnh (Products_Images)
    public function images()
    {
        return $this->hasMany(ProductImage::class);  // nhánh chân gà
    }



    // 3. Một sản phẩm có thể nằm trong nhiều giỏ hàng (Cart_Items)
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);   // nhánh chân gà
    }



    // 4. Một sản phẩm có thể xuất hiện trong nhiều đơn hàng (Order_Items)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);   // nhánh chân gà
    }



    // 5. Một sản phẩm có thể có nhiều đánh giá từ người dùng (Reviews)
    public function reviews()
    {
        return $this->hasMany(Review::class);   // nhánh chân gà
    }


    // 6. Một sản phẩm có thể thuộc về nhiều công thức nấu ăn (Recipes) thông qua bảng trung gian Product_Recipe
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'product_recipe')
                    ->withPivot('quantity');   // lưu thêm số lượng trong bảng trung gian
    }



    public function firstImage()
    {
        return $this->hasOne(ProductImage::class)->orderBy('id', 'asc');
    }


}
