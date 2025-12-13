<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    public $timestamps = false;
    protected $fillable = ['name', 'slug', 'description', 'image'];

    // Một Recipe có thể chứa nhiều Product thông qua bảng trung gian product_recipe
    public function products()
    {
        // Thêm chữ 's' vào tên bảng trung gian
        return $this->belongsToMany(Product::class, 'product_recipes', 'recipe_id', 'product_id')
            ->withPivot('quantity');
    }
}
