<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;

class StoreProductController extends Controller
{
    // Show form to register product to a store
    public function create(Store $store)
    {
        $products = Product::all();
        return view('store_products.create', compact('store', 'products'));
    }

    // Store the registration (attach product to store with quantity, delivery, expire)
    public function store(Request $request, Store $store)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'delivered_at' => 'nullable|date',
        ]);

        $product = Product::findOrFail($data['product_id']);

        $store->products()->attach($product->id, [
            'quantity'     => $data['quantity'],
            'delivered_at' => $data['delivered_at'] ?? now(),
            'expire_date'  => $product->expire_date, // pulled from product
        ]);

        return redirect()->route('stores.show', $store)
            ->with('success', 'Product registered to store!');
    }
}
