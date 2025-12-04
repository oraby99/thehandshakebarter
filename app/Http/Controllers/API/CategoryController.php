<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('subCategories')->get();

        return response()->json([
            'data' => $categories
        ]);
    }

    public function show(Category $category)
    {
        return response()->json([
            'data' => $category->load('subCategories')
        ]);
    }
}
