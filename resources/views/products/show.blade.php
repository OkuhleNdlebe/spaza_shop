@extends('layouts.app')

@section('title', 'Product Details')

@section('content')
<div class="container">
    <div class="card shadow p-4">
        <h2 class="text-primary">{{ $product->name }}</h2>
        <p><strong>Description:</strong> {{ $product->description }}</p>
        <p><strong>Manufacturer:</strong> {{ $product->manufacturer }}</p>
        <p><strong>Expiry Date:</strong> {{ $product->expiry_date }}</p>
        <p><strong>Supplier:</strong> {{ $product->supplier->company_name }}</p>

        <h3>QR Code</h3>
        <div>{!! $product->qr_code !!}</div>
    </div>
</div>
@endsection
