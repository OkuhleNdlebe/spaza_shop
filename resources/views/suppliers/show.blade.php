@extends('layouts.app')

@section('title', 'Supplier Details')

@section('content')
<div class="container">
    <div class="card shadow p-4">
        <h2 class="text-primary">{{ $supplier->company_name }}</h2>
        <p><strong>Contact Person:</strong> {{ $supplier->contact_person }}</p>
        <p><strong>Phone:</strong> {{ $supplier->phone_number }}</p>
        <p><strong>Email:</strong> {{ $supplier->email }}</p>
        <p><strong>Address:</strong> {{ $supplier->address }}</p>

        <h3>QR Code</h3>
        <div>{!! $qrcode !!}</div>

        <h3>Products</h3>
    </div>

@if($supplier->products->count())
<div class="card mt-4">
    <div class="card-header bg-info text-white">
        <h5>Performance Metrics</h5>
    </div>
    <div class="card-body">
        @php $metrics = $supplier->performanceMetrics(); @endphp
        
        <div class="row text-center">
            <div class="col-md-3">
                <div class="metric-card">
                    <h3>{{ $metrics['total_products'] }}</h3>
                    <p>Total Products</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card">
                    <h3>{{ $metrics['products_in_stock'] }}</h3>
                    <p>In Stock</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card">
                    <h3>{{ $metrics['average_delivery_time'] }} days</h3>
                    <p>Avg. Delivery Time</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="metric-card">
                    <h3>
                        @for($i = 1; $i <= 5; $i++)
                            <i class="bi bi-star{{ $i <= $metrics['quality_rating'] ? '-fill' : '' }} text-warning"></i>
                        @endfor
                    </h3>
                    <p>Quality Rating</p>
                </div>
            </div>
        </div>
        
        <div class="mt-3">
            <h6>Performance Over Time</h6>
            <canvas id="supplierPerformanceChart" height="100"></canvas>
        </div>
    </div>
</div>
@endif
</div>
@endsection
