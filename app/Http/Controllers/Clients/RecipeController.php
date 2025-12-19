<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Models\Recipe;
use Illuminate\Http\Request;

class RecipeController extends Controller
{

    public function index()
    {
        $recipes = Recipe::all();

        return view('user.pages.recipes', compact('recipes'));
    }

    //  Ajax lấy nguyên liệu Popup
    public function getIngredients(Request $request)
    {
        $recipe = Recipe::with(['products' => function ($q) {
            $q->with('images');
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
