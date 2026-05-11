<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        // ১. ভ্যালিডেশন
        $request->validate([
            'name'          => 'required|string',
            'phone'         => 'required',
            'address'       => 'required',
            'shipping_info' => 'required|exists:shipping_charges,id',
        ]);

        $ip_address = $request->ip();
        $shipping_info = ShippingCharge::find($request->shipping_info);
        $shipping_charge = $shipping_info->amount;

        if (Auth::guard('customer')->check()) {
            $customer_id = Auth::guard('customer')->id();
        } else {
            $exists_customer = Customer::where('phone', $request->phone)->first();

            if ($exists_customer) {
                $customer_id = $exists_customer->id;
            } else {
                $customer           = new Customer();
                $customer->name     = $request->name;
                $customer->phone    = $request->phone;
                $customer->email    = $request->email;
                $customer->password = Hash::make(rand(111111, 999999));
                $customer->save();
                $customer_id = $customer->id;
            }
        }

        // database Cart Table to data
        $carts = Cart::where('ip_address', $ip_address)
            ->orWhere('customer_id', $customer_id)
            ->get();

        if ($carts->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'Your cart is empty'], 400);
        }

        // subtotal calculation
        $subtotal = $carts->sum(function ($cart) {
            return $cart->quantity * $cart->new_price;
        });

        $discount = 0;
        $total = ($subtotal + $shipping_charge) - $discount;

        // order save
        $order                  = new Order();
        $order->invoice_id      = rand(11111, 99999);
        $order->subtotal        = $subtotal;
        $order->discount        = $discount;
        $order->shipping_charge = $shipping_charge;
        $order->total           = $total;
        $order->customer_id     = $customer_id;
        $order->order_status    = 1;
        $order->phone           = $request->phone;
        $order->customer_note   = $request->customer_note;
        $order->save();

        // OrderDetails save
        foreach ($carts as $item) {
            $product = Product::find($item->product_id);

            $order_details = new OrderDetails();
            $order_details->order_id               = $order->id;
            $order_details->product_id             = $product->id;
            $order_details->product_name           = $product->product_name;
            $order_details->purchase_price         = $product->purchase_price;
            $order_details->sale_price             = $item->new_price;

            // variant product set
            if ($product->product_type == 1) {
                $inventory = Inventory::where([
                    'product_id' => $product->id,
                    'color_id'   => $item->color_id,
                    'size_id'    => $item->size_id
                ])->first();

                $order_details->variant_purchase_price = $inventory->purchase_price ?? 0;
                $order_details->variant_sale_price     = $inventory->price ?? 0;
            }

            $order_details->product_size  = $item->size_id;
            $order_details->product_color = $item->color_id;
            $order_details->quantity      = $item->quantity;
            $order_details->save();

            if ($product->product_type == 1) {
                $inventory = Inventory::where([
                    'product_id' => $product->id,
                    'color_id'   => $item->color_id,
                    'size_id'    => $item->size_id
                ])->first();

                $order_details->variant_purchase_price = $inventory->purchase_price ?? 0;
                $order_details->variant_sale_price     = $inventory->price ?? 0;

                if ($inventory) {
                    $inventory->decrement('stock', $item->quantity);
                }
            } else {
                $product->decrement('stock', $item->quantity);
            }
        }

        // Shipping Info save
        $shipping               = new Shipping();
        $shipping->order_id     = $order->id;
        $shipping->customer_id  = $customer_id;
        $shipping->name         = $request->name;
        $shipping->phone        = $request->phone;
        $shipping->email        = $request->email;
        $shipping->address      = $request->address;
        $shipping->area         = $shipping_info->name;
        $shipping->save();

        // Payment Info save
        $payment                  = new Payment();
        $payment->order_id        = $order->id;
        $payment->customer_id     = $customer_id;
        $payment->amount          = $total;
        $payment->payment_method  = 'Cash On Delivery';
        $payment->payment_status  = 'pending';
        $payment->save();

        // order cart remove
        Cart::where('ip_address', $ip_address)->orWhere('customer_id', $customer_id)->delete();

        $data = Order::with([
            'orderdetails:id,order_id,product_name,product_color,product_size,quantity',
            'shipping:id,order_id,name,phone,email,address,area',
            'payment:id,order_id,amount,payment_method,payment_status'
        ])->where('invoice_id', $request->invoice_id)
            ->first();

        return response()->json([
            'status'  => true,
            'data' => $data,
            'message' => 'Order placed successfully'
        ], 201);
    }

    public function trackOrder(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:orders,invoice_id',
        ]);

        $order = Order::where('invoice_id', $request->invoice_id)->first();

        if (!$order) {
            return response()->json(['status' => false, 'message' => 'Order not found'], 404);
        }

        $data = Order::with([
            'orderdetails:id,order_id,product_name,product_color,product_size,quantity',
            'shipping:id,order_id,name,phone,email,address,area',
            'payment:id,order_id,amount,payment_method,payment_status'
        ])->where('invoice_id', $request->invoice_id)
            ->first();

        return response()->json([
            'status' => true,
            'data' => $data,
            'message' => 'Order track successfully'
        ], 200);
    }
}
