<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['name', 'slug', 'description', 'image'];


    // Một Recipe có thể chứa nhiều Product thông qua bảng trung gian product_recipe
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_recipe')
                    ->withPivot('quantity');   // thêm cột trung gian
                    
    }
}
