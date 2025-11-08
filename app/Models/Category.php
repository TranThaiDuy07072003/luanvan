<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'description', 'slug', 'image'];

    
    // Một category có thể có nhiều product (quan hệ 1-n)
    public function products()
    {
        return $this->hasMany(Product::class);  // nhánh chân gà
    }
}
