@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="container">
    <div class="card shadow p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-primary mb-0">{{ $product->name }}</h2>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Products
            </a>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <p><strong>Description:</strong> {{ $product->description ?? 'No description' }}</p>
                <p><strong>Manufacturer:</strong> {{ $product->manufacturer ? $product->manufacturer->name : 'N/A' }}</p>
                <p><strong>Expiry Date:</strong> {{ $product->expiry_date ? \Carbon\Carbon::parse($product->expiry_date)->format('M j, Y') : 'N/A' }}</p>
                <p><strong>Supplier:</strong> {{ $product->supplier ? $product->supplier->company_name : 'N/A' }}</p>
                <p><strong>Price:</strong> R{{ number_format($product->price, 2) }}</p>
            </div>
            <div class="col-md-6">
                <h4>QR Code</h4>
                <div class="text-center">
                    @if($product->qr_code)
                        {!! $product->qr_code !!}
                    @else
                        <div class="alert alert-info">
                            <p>No QR Code generated yet.</p>
                            <form action="{{ route('products.generate-qr', $product) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="bi bi-qr-code"></i> Generate QR Code
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Stores that have this product -->
    <div class="card shadow p-4 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="text-success">Stores with this Product</h3>
            <a href="{{ route('store_products.create', ['store' => 1]) }}?product_id={{ $product->id }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add to Store
            </a>
        </div>

        @if($product->stores->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-success">
                    <tr>
                        <th>Store Name</th>
                        <th>Location</th>
                        <th>Quantity</th>
                        <th>Delivered At</th>
                        <th>Expire Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($product->stores as $store)
                    <tr>
                        <td>{{ $store->name }}</td>
                        <td>{{ $store->location }}</td>
                        <td>
                            <span class="badge bg-{{ $store->pivot->quantity < 5 ? 'danger' : 'success' }}">
                                {{ $store->pivot->quantity }}
                            </span>
                        </td>
                        <td>{{ $store->pivot->delivered_at ? \Carbon\Carbon::parse($store->pivot->delivered_at)->format('M j, Y') : 'N/A' }}</td>
                        <td>{{ $store->pivot->expire_date ? \Carbon\Carbon::parse($store->pivot->expire_date)->format('M j, Y') : 'N/A' }}</td>
                        <td>
                            <a href="{{ route('stores.show', $store) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i> View Store
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> This product is not currently in any store.
        </div>
        @endif
    </div>

    <!-- Quick Actions -->
    <div class="card shadow p-4 mt-4">
        <h4 class="text-primary mb-3">Quick Actions</h4>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('products.edit', $product) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit Product
            </a>
            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')">
                    <i class="bi bi-trash"></i> Delete Product
                </button>
            </form>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="bi bi-list"></i> All Products
            </a>
        </div>
    </div>
</div>
@endsection