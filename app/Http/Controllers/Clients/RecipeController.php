<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    // 1. Hiển thị trang danh sách món ăn
    public function index()
    {
        $recipes = Recipe::all(); // Lấy tất cả món ăn

        return view('user.pages.recipes', compact('recipes')); // Trả về View bạn vừa tạo
    }

    // 2. Ajax lấy nguyên liệu (Popup)
    public function getIngredients(Request $request)
    {
        $recipe = Recipe::with(['products' => function ($q) {
            $q->with('images'); // đổi từ firstImage sang images
        }])->find($request->id);

        if ($recipe) {
            $html_content = view('user.components.modals.recipe_ingredients_list', [
                'products' => $recipe->products,
            ])->render();

            return response()->json([
                'status' => true,
                'recipe_name' => $recipe->name,
                'html' => $html_content,
            ]);
        }

        return response()->json(['status' => false, 'message' => 'Không tìm thấy']);
    }
}
