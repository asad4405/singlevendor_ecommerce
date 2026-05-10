<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Inventory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1',
            'color_id'   => 'nullable',
            'size_id'    => 'nullable',
        ]);

        $product = Product::find($request->product_id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }

        $ip_address = $request->ip();

        $customer_id = Auth::guard('customer')->check()
            ? Auth::guard('customer')->id()
            : null;

        $requestQty = (int) $request->quantity;

        $stock = 0;

        // PRODUCT TYPE 1 (VARIANT)

        if ($product->product_type == 1) {

            $request->validate([
                'color_id' => 'required',
                'size_id'  => 'required',
            ]);

            $inventory = Inventory::where('product_id', $product->id)
                ->where('color_id', $request->color_id)
                ->where('size_id', $request->size_id)
                ->first();

            if (!$inventory) {
                return response()->json([
                    'status' => false,
                    'message' => 'Inventory not found'
                ], 404);
            }

            $stock = $inventory->stock;
        }

        // SIMPLE PRODUCT
        else {
            $stock = $product->stock;
        }

        // CART CHECK
        $cart = Cart::where('product_id', $product->id)
            ->where('ip_address', $ip_address)
            ->where('customer_id', $customer_id)
            ->where('color_id', $request->color_id ?? null)
            ->where('size_id', $request->size_id ?? null)
            ->first();

        $currentQty = $cart ? $cart->quantity : 0;
        $totalQty   = $currentQty + $requestQty;

        // STOCK VALIDATION
        if ($totalQty > $stock) {
            return response()->json([
                'status'  => false,
                'message' => 'Stock limit exceeded',
                'stock'   => $stock
            ], 400);
        }

        // SAVE CART
        if ($cart) {
            $cart->quantity = $totalQty;
            $cart->save();
        } else {
            $cart = new Cart();
            $cart->ip_address  = $ip_address;
            $cart->customer_id = $customer_id;
            $cart->product_id  = $product->id;
            $cart->color_id    = $request->color_id ?? null;
            $cart->size_id     = $request->size_id ?? null;
            $cart->quantity    = $requestQty;
            $cart->new_price   = $product->product_type == 1 ? $inventory->price : $product->new_price;
            $cart->old_price   = $product->product_type == 1 ? $inventory->old_price : $product->old_price;
            $cart->save();
        }

        $data = Cart::with(['product:id,product_name,product_image', 'color:id,color_name', 'size:id,size_name'])
            ->where('id', $cart->id)
            ->select('id', 'product_id', 'color_id', 'size_id', 'quantity', 'new_price', 'old_price')
            ->first();

        return response()->json([
            'status'  => true,
            'message' => 'Product added to cart successfully',
            'data'    => $data
        ]);
    }

    public function cartProducts(Request $request)
    {
        $ip_address = $request->ip();

        $customer_id = Auth::guard('customer')->check()
            ? Auth::guard('customer')->id()
            : null;

        $carts = Cart::with(['product:id,product_name,product_image', 'color:id,color_name', 'size:id,size_name'])
            ->where('ip_address', $ip_address)
            ->when($customer_id, function ($q) use ($customer_id) {
                $q->orWhere('customer_id', $customer_id);
            })
            ->get();

        if ($carts->isEmpty()) {
            return response()->json([
                'status'  => false,
                'message' => 'Cart is empty',
                'data'    => []
            ]);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Cart products fetched successfully',
            'data'    => $carts
        ]);
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'cart_id' => 'required|integer|exists:carts,id',
        ]);

        $cart = Cart::find($request->cart_id);
        $cart->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Product removed from cart successfully'
        ]);
    }
}
