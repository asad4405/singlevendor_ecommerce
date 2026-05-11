<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function frontCategoryProducts()
    {
        $categories = Category::where('status',1)
            ->orderBy('id', 'ASC')
            ->with(['products', 'products.image', 'products.inventory','products.inventory.color',
            'products.inventory.size'])
            ->get();

        $data = [];

        foreach ($categories as $category) {
            $data[] = [
                'category_id'   => $category->id,
                'category_name' => $category->category_name,
                'slug'          => $category->slug,
                'front_view'    => $category->front_view,
                'products'      => $category->products
            ];
        }

        return response()->json([
            'status'  => true,
            'data'    => $data,
            'message' => 'Category wise product fetch successfully'
        ], 200);
    }
}
