@extends('layouts.app')

@section('title', 'Edit Sale')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <h5 class="mb-0">Edit Sale #{{ $sale->id }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sales.update', $sale) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <!-- Same fields as create form, pre-filled with $sale data -->
                        <div class="mb-3">
                            <label class="form-label">Store</label>
                            <select name="store_id" class="form-select" required>
                                @foreach($stores as $store)
                                <option value="{{ $store->id }}" {{ $sale->store_id == $store->id ? 'selected' : '' }}>
                                    {{ $store->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Product</label>
                            <select name="product_id" class="form-select" required>
                                @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ $sale->product_id == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" class="form-control" value="{{ $sale->quantity }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Unit Price</label>
                            <input type="number" step="0.01" name="unit_price" class="form-control" value="{{ $sale->unit_price }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Sale Date</label>
                            <input type="datetime-local" name="sale_date" class="form-control" value="{{ $sale->sale_date->format('Y-m-d\TH:i') }}" required>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Notes</label>
                            <textarea name="notes" class="form-control" rows="3">{{ $sale->notes }}</textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-warning">Update Sale</button>
                        <a href="{{ route('sales.show', $sale) }}" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection