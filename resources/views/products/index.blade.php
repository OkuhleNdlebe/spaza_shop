@extends('layouts.app')

@section('title', 'Products')

@section('content')
<div class="container">
    <h2>Products</h2>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">Add Product</a>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Products</h2>
        <div>
            <a href="{{ route('products.export') }}" class="btn btn-outline-primary me-2">
                <i class="bi bi-download"></i> Export CSV
            </a>
            
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Add Product
            </a>
        </div>
    </div>


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Description</th>
                <th>Manufacturer</th>
                <th>Expiry Date</th>
                <th>Supplier</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ Str::limit($product->description, 50) }}</td>
                    <td>{{ $product->manufacturer ? $product->manufacturer->name : 'N/A' }}</td>
                    <td>{{ $product->expiry_date }}</td>
                    <td>{{ $product->supplier ? $product->supplier->company_name : 'N/A' }}</td>
                    <td>
                        <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm">View Details</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection