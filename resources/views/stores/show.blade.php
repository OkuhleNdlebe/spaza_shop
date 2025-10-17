@extends('layouts.app')

@section('title', 'Store Details')

@section('content')

@if($lowStockProducts->count())
<div class="alert alert-warning alert-dismissible fade show">
    <h5><i class="bi bi-exclamation-triangle"></i> Low Stock Alert</h5>
    <p>The following products are running low:</p>
    <ul>
        @foreach($lowStockProducts as $product)
        <li>{{ $product->name }} (Only {{ $product->pivot->quantity }} left)</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif
<div class="container mt-4">
    <div class="card shadow p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="text-primary mb-0">{{ $store->name }}</h2>
            </div>
            <div>
                <a href="{{ route('store_products.create', $store) }}" class="btn btn-success me-2">
                    <i class="bi bi-plus-circle"></i> Add Product
                </a>
                <a href="{{ route('store_products.create', $store) }}" class="btn btn-outline-success">
                    <i class="bi bi-bag-plus"></i> Add Multiple Products
                </a>
            </div>
        </div>
        <p><strong>Location:</strong> {{ $store->location }}</p>
        <p><strong>Owner:</strong> {{ $store->owner_name }}</p>
        <p><strong>Contact:</strong> {{ $store->contact_number }}</p>

        <h3>QR Code</h3>
        <div>{!! $qrCode !!}</div> <!-- This will display the QR code -->

        <div class="mt-4 d-flex justify-content-between">
            <a href="{{ route('stores.index') }}" class="btn btn-secondary">Back to Stores</a>
            <div>
                <a href="{{ route('store_products.create', $store) }}" class="btn btn-success me-2">
                    <i class="bi bi-plus-circle"></i> Add Product
                </a>
                <a href="{{ route('store_products.create', $store) }}" class="btn btn-outline-success">
                    <i class="bi bi-bag-plus"></i> Add Multiple Products
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Add Product Buttons (already present above) -->

<h3 class="mt-5">Products in this Store</h3>
@if($store->products->count())
<table class="table table-bordered table-striped align-middle">
    <thead class="table-success">
        <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Delivered At</th>
            <th>Expire Date</th>
            <th>QR Code</th>
        </tr>
    </thead>
    <tbody>
        @foreach($store->products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->pivot->quantity }}</td>
            <td>{{ $product->pivot->delivered_at }}</td>
            <td>{{ $product->pivot->expire_date }}</td>
           
        </tr>
        @endforeach
    </tbody>
</table>
@else
    <div class="alert alert-info mt-3">No products are registered in this store yet.</div>
@endif
@endsection