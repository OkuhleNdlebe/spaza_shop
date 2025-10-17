@extends('layouts.app')

@section('title', 'Add Product')

@section('content')
<div class="container">
    <h2>Add Product</h2>
    
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        
        <!-- Supplier Dropdown -->
        <div class="mb-3">
            <label class="form-label">Select Supplier</label>
            <select name="supplier_id" class="form-control" required>
                <option value="" disabled selected>Select Supplier</option>
                @foreach($suppliers as $supplier)
                    <option value="{{ $supplier->id }}">{{ $supplier->company_name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Product Name -->
        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <!-- Manufacturer Dropdown -->
        <div class="mb-3">
            <label class="form-label">Manufacturer</label>
            <select name="manufacturer_id" class="form-control" required>
                <option value="" disabled selected>Select Manufacturer</option>
                @foreach($manufacturers as $manufacturer)
                    <option value="{{ $manufacturer->id }}">{{ $manufacturer->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Expiry Date -->
        <div class="mb-3">
            <label class="form-label">Expiry Date</label>
            <input type="date" name="expiry_date" class="form-control">
        </div>

        <!-- Price -->
        <div class="mb-3">
            <label class="form-label">Price</label>
            <input type="number" name="price" class="form-control" step="0.01" required>
        </div>

        <button type="submit" class="btn btn-primary">Save Product</button>
    </form>
</div>
@endsection