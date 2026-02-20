<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Size;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $product = Product::find($id);
        $product_id = Product::find($id)->id;
        $colors = Color::where('status', 1)->latest()->get();
        $sizes = Size::where('status', 1)->latest()->get();
        $inventories = Inventory::where('product_id', $product_id)->get();
        return view('Backend.pages.inventory.index', compact('product', 'colors', 'sizes', 'inventories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            '*' => 'required'
        ]);
        // return $request;
        if (Inventory::where([
            'product_id' => $request->product_id,
            'color_id' => $request->color_id,
            'size_id' => $request->size_id,
        ])->exists()) {
            Inventory::where([
                'product_id' => $request->product_id,
                'color_id' => $request->color_id,
                'size_id' => $request->size_id,
            ])->increment('stock', $request->stock);
            return back()->with('inventory_success', 'Inventory Added!');
        } else {
            $inventory = new Inventory();
            $inventory->product_id = $request->product_id;
            $inventory->color_id = $request->color_id;
            $inventory->size_id = $request->size_id;
            $inventory->stock = $request->stock;
            $inventory->price = $request->price;
            $inventory->old_price = $request->old_price;
            $inventory->status = 1;
            $inventory->save();
            return back()->with('inventory_success', 'New Inventory Added!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $inventory = Inventory::find($id);
        $colors = Color::where('status', 1)->latest()->get();
        $sizes = Size::where('status', 1)->latest()->get();
        $inventories = Inventory::where('product_id', $inventory->product_id)->get();
        return view('Backend.pages.inventory.edit', compact('inventory','colors','sizes','inventories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $inventory = Inventory::find($id);
        $inventory->product_id = $request->product_id;
        $inventory->color_id = $request->color_id;
        $inventory->size_id = $request->size_id;
        $inventory->stock = $request->stock;
        $inventory->price = $request->price;
        $inventory->old_price = $request->old_price;
        $inventory->save();
        return redirect()->route('admin.inventory.index',$inventory->product_id)->with('inventory_success', 'Inventory Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $inventory = Inventory::find($id);
        $inventory->delete();
        return back()->with('inventory_success', 'Inventory Delated!');
    }
}
