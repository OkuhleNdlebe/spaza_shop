@extends('layouts.app')
@section('title', 'Register Product to Store')
@section('content')
<div class="container">
    <h3>Add Product to <span class="text-success">{{ $store->name }}</span></h3>
    <form method="POST" action="{{ route('store_products.store', $store) }}" class="mt-3" autocomplete="off">
        @csrf
        <div class="mb-3">
            <label for="product_id" class="form-label">Product</label>
            <select name="product_id" id="product_id" class="form-control" required>
                <option value="">-- Select Product --</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">
                        {{ $product->name }} (Expires: {{ $product->expire_date ?? 'N/A' }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="number" name="quantity" id="quantity" class="form-control" min="1" value="1" required>
        </div>
        <div class="mb-3">
            <label for="delivered_at" class="form-label">Delivered At</label>
            <input type="date" name="delivered_at" id="delivered_at" class="form-control" value="{{ date('Y-m-d') }}">
        </div>
        <button type="submit" class="btn btn-success">Register Product</button>
        <a href="{{ route('stores.show', $store) }}" class="btn btn-secondary">Back to Store</a>
    </form>
</div>
@endsection