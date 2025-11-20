<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Rau củ', 'slug' => 'rau-cu', 'description' => 'Các loại rau củ tươi ngon', 'image' => 'uploads/categories/rau-cu.png'],
            ['name' => 'Trái cây', 'slug' => 'trai-cay', 'description' => 'Các loại trái cây tươi ngon', 'image' => 'uploads/categories/trai-cay.png'],
            ['name' => 'Thịt', 'slug' => 'thit', 'description' => 'Các loại thịt tươi ngon', 'image' => 'uploads/categories/thit.png'],
            ['name' => 'Cá', 'slug' => 'ca', 'description' => 'Các loại hải sản tươi ngon', 'image' => 'uploads/categories/ca.png'],
            ['name' => 'Thực phẩm khác', 'slug' => 'thuc-pham-khac', 'description' => 'Các loại thực phẩm bổ sung', 'image' => 'uploads/categories/thuc-pham-khac.png'],
        ];

        foreach($categories as $category){
            Category::create($category);
        }
    }


}
