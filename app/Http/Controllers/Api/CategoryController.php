<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categoryList()
    {
        $categories = Category::where('status',1)->select('id','category_name','slug','image')->get();
        return response()->json([
            'status' => true,
            'data' => $categories,
            'message' => 'Category List fetch successfully!'
        ]);
    }
    public function menuCategories()
    {
        $categories = Category::where('status',1)->select('id','category_name','slug','image')->with(['subcategories.childcategories'])->get();
        return response()->json([
            'status' => true,
            'data' => $categories,
            'message' => 'Category List fetch successfully!'
        ]);
    }
}
