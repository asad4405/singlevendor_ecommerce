<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function frontCategoryProducts()
    {
        $categories = Category::where('status', 1)
            ->orderBy('id', 'ASC')
            ->with([
                'products',
                'products.image',
                'products.inventory',
                'products.inventory.color',
                'products.inventory.size'
            ])
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

    public function productDetails(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)
            ->select('id', 'product_name', 'product_code', 'product_image', 'product_type', 'category_id', 'subcategory_id', 'childcategory_id', 'old_price', 'new_price', 'stock', 'product_unit', 'product_video', 'short_description', 'description')
            ->with('inventory')->first();

        return response()->json([
            'status' => true,
            'data' => $product,
            'messsage' => 'Product details data fetch successfully!'
        ]);
    }

    public function relatedProducts($slug)
    {
        $product = Product::where('slug', $slug)->select('id', 'category_id')->first();
        $category_id = $product->id;
        $relatedProducts = Product::where('category_id', $category_id)
            ->select('id', 'product_name', 'product_image', 'product_type', 'old_price', 'new_price')
            ->where('id', '!=', $product->id)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $relatedProducts,
            'messsage' => 'Related product data fetch successfully!'
        ]);
    }
}
