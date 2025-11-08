<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductRecipe extends Model
{
    protected $table = 'product_recipe'; // chỉ định đúng tên bảng trung gian

    protected $fillable = ['recipe_id', 'product_id', 'quantity'];

    // Mỗi bản ghi trung gian thuộc về 1 recipe
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    // Mỗi bản ghi trung gian thuộc về 1 product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
