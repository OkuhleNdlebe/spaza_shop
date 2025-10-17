@extends('layouts.app')

@section('title', 'Sale Details - ' . $sale->id)

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sale Details</h2>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Sales
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Sale Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Sale ID:</strong> #{{ $sale->id }}</p>
                            <p><strong>Date & Time:</strong> {{ $sale->sale_date->format('M j, Y H:i') }}</p>
                            <p><strong>Store:</strong> {{ $sale->store->name }}</p>
                            <p><strong>Location:</strong> {{ $sale->store->location }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Product:</strong> {{ $sale->product->name }}</p>
                            <p><strong>Quantity:</strong> {{ $sale->quantity }}</p>
                            <p><strong>Unit Price:</strong> R{{ number_format($sale->unit_price, 2) }}</p>
                            <p><strong>Total Amount:</strong> R{{ number_format($sale->total_amount, 2) }}</p>
                        </div>
                    </div>

                    @if($sale->notes)
                    <div class="mt-3">
                        <strong>Notes:</strong>
                        <p class="text-muted">{{ $sale->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('sales.edit', $sale) }}" class="btn btn-warning">
                            <i class="bi bi-pencil"></i> Edit Sale
                        </a>
                        <form action="{{ route('sales.destroy', $sale) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                                    onclick="return confirm('Are you sure you want to delete this sale?')">
                                <i class="bi bi-trash"></i> Delete Sale
                            </button>
                        </form>
                        <a href="{{ route('sales.create') }}?store_id={{ $sale->store_id }}&product_id={{ $sale->product_id }}" 
                           class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> New Sale (Same Store/Product)
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Product Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Supplier:</strong> {{ $sale->product->supplier->company_name ?? 'N/A' }}</p>
                    <p><strong>Manufacturer:</strong> {{ $sale->product->manufacturer->name ?? 'N/A' }}</p>
                    <p><strong>Expiry Date:</strong> {{ $sale->product->expiry_date ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection