@extends('layouts.app')

@section('title', 'Store Details')

@section('content')
<div class="container">
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
    
    <div class="card shadow p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="text-primary mb-0">{{ $store->name }}</h2>
                <p class="text-muted mb-0">{{ $store->location }}</p>
            </div>
            <div>
                <a href="{{ route('store_products.create', $store) }}" class="btn btn-success me-2">
                    <i class="bi bi-plus-circle"></i> Add Product
                </a>
                <a href="{{ route('stores.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Stores
                </a>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-md-6">
                <p><strong>Owner:</strong> {{ $store->owner_name }}</p>
                <p><strong>Contact:</strong> {{ $store->contact_number }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Low Stock Threshold:</strong> {{ $store->low_stock_threshold ?? 5 }}</p>
                <p><strong>Total Products:</strong> {{ $store->products->count() }}</p>
            </div>
        </div>

        <h4>Store QR Code</h4>
        <div class="text-center mb-4">
            {!! $qrCode !!}
        </div>
    </div>

    <!-- Products in this Store -->
    <div class="card shadow p-4 mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="text-success">Products in this Store</h3>
            <span class="badge bg-primary">{{ $store->products->count() }} products</span>
        </div>

        @if($store->products->count())
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-success">
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Delivered At</th>
                        <th>Expire Date</th>
                        <th>Days Until Expiry</th>
                        <th>QR Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($store->products as $product)
                    @php
                        $expireDate = \Carbon\Carbon::parse($product->pivot->expire_date);
                        $daysUntilExpiry = $expireDate->diffInDays(now());
                        $isExpiringSoon = $daysUntilExpiry <= 30;
                    @endphp
                    <tr class="{{ $isExpiringSoon ? 'table-warning' : '' }}">
                        <td>
                            <strong>{{ $product->name }}</strong>
                            @if($isExpiringSoon)
                                <span class="badge bg-danger ms-1">Expiring Soon</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-{{ $product->pivot->quantity < ($store->low_stock_threshold ?? 5) ? 'danger' : 'success' }}">
                                {{ $product->pivot->quantity }}
                            </span>
                        </td>
                        <td>{{ $product->pivot->delivered_at ? \Carbon\Carbon::parse($product->pivot->delivered_at)->format('M j, Y') : 'N/A' }}</td>
                        <td>{{ $product->pivot->expire_date ? \Carbon\Carbon::parse($product->pivot->expire_date)->format('M j, Y') : 'N/A' }}</td>
                        <td>
                            @if($product->pivot->expire_date)
                                <span class="badge bg-{{ $daysUntilExpiry <= 7 ? 'danger' : ($daysUntilExpiry <= 30 ? 'warning' : 'success') }}">
                                    {{ $daysUntilExpiry }} days
                                </span>
                            @else
                                <span class="badge bg-secondary">N/A</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @if($product->qr_code)
                                {!! $product->qr_code !!}
                            @else
                                <span class="text-muted">No QR</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm">
                                <i class="bi bi-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-info text-center">
            <i class="bi bi-info-circle" style="font-size: 2rem;"></i>
            <h5 class="mt-3">No products in this store yet</h5>
            <p class="text-muted">Add products to this store to start tracking inventory.</p>
            <a href="{{ route('store_products.create', $store) }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add First Product
            </a>
        </div>
        @endif
    </div>
</div>
@endsection