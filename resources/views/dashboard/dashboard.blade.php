@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
@if(isset($expiringSoon) && $expiringSoon->count())
<div class="alert alert-danger">
    <h5><i class="bi bi-exclamation-triangle"></i> Products Expiring Soon</h5>
    @foreach($expiringSoon as $alert)
    <div class="mb-2">
        <strong>{{ $alert->product->name }}</strong> at 
        <strong>{{ $alert->store->name }}</strong> 
        expires in {{ $alert->days_until_expiry }} days
        ({{ $alert->expiry_date->format('M j, Y') }})
    </div>
    @endforeach
</div>
@endif
    <!-- Header with refresh button -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Dashboard Overview</h2>
        <div>
            <small class="text-muted me-3">Last updated: {{ now()->format('M j, Y g:i A') }}</small>
            <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-clockwise"></i> Refresh
            </a>
        </div>
    </div>

    <!-- Quick Search -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Quick Search</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('stores.index') }}" class="btn btn-outline-primary w-100">
                                <i class="bi bi-search"></i> Search Stores
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-success w-100">
                                <i class="bi bi-search"></i> Search Products
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('suppliers.index') }}" class="btn btn-outline-info w-100">
                                <i class="bi bi-search"></i> Search Suppliers
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('manufacturers.index') }}" class="btn btn-outline-warning w-100">
                                <i class="bi bi-search"></i> Search Manufacturers
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Main Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title display-6">{{ $stats['total_stores'] }}</h5>
                    <p class="card-text">Total Stores</p>
                    <a href="{{ route('stores.index') }}" class="text-white">View Stores</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title display-6">{{ $stats['total_products'] }}</h5>
                    <p class="card-text">Total Products</p>
                    <a href="{{ route('products.index') }}" class="text-white">View Products</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title display-6">{{ $stats['total_suppliers'] }}</h5>
                    <p class="card-text">Total Suppliers</p>
                    <a href="{{ route('suppliers.index') }}" class="text-white">View Suppliers</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title display-6">{{ $stats['total_manufacturers'] }}</h5>
                    <p class="card-text">Total Manufacturers</p>
                    <a href="{{ route('manufacturers.index') }}" class="text-white">View Manufacturers</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-secondary mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title display-6">{{ $stats['stores_with_products'] }}</h5>
                    <p class="card-text">Stores with Products</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title display-6">{{ $stats['products_near_expiry'] }}</h5>
                    <p class="card-text">Products Near Expiry</p>
                    <a href="{{ route('products.index') }}?filter=expiring" class="text-white">View Details</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-dark mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title display-6">{{ $stats['total_store_products'] }}</h5>
                    <p class="card-text">Total Stock Items</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info mb-3">
                <div class="card-body text-center">
                    <h5 class="card-title display-6">{{ $stats['recent_products']->count() }}</h5>
                    <p class="card-text">Recent Products</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5><i class="bi bi-bar-chart"></i> Stores Statistics</h5>
                </div>
                <div class="card-body">
                    <canvas id="storesChart" height="250"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5><i class="bi bi-pie-chart"></i> Products Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="productsChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Sections -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5><i class="bi bi-shop"></i> Recent Stores</h5>
                </div>
                <div class="card-body">
                    @if($stats['recent_stores']->count())
                        @foreach($stats['recent_stores'] as $store)
                            <div class="d-flex justify-content-between align-items-center mb-3 p-2 border-bottom">
                                <div>
                                    <h6 class="mb-1">{{ $store->name }}</h6>
                                    <small class="text-muted">{{ $store->location }}</small>
                                </div>
                                <small class="text-muted">{{ $store->created_at->diffForHumans() }}</small>
                            </div>
                        @endforeach
                        <a href="{{ route('stores.index') }}" class="btn btn-outline-primary btn-sm mt-2 w-100">View All Stores</a>
                    @else
                        <p class="text-muted">No recent stores found.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5><i class="bi bi-box-seam"></i> Recent Products</h5>
                </div>
                <div class="card-body">
                    @if($stats['recent_products']->count())
                        @foreach($stats['recent_products'] as $product)
                            <div class="d-flex justify-content-between align-items-center mb-3 p-2 border-bottom">
                                <div>
                                    <h6 class="mb-1">{{ $product->name }}</h6>
                                    <small class="text-muted">Supplier: {{ $product->supplier->company_name ?? 'N/A' }}</small>
                                </div>
                                <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                            </div>
                        @endforeach
                        <a href="{{ route('products.index') }}" class="btn btn-outline-success btn-sm mt-2 w-100">View All Products</a>
                    @else
                        <p class="text-muted">No recent products found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Activity Timeline -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5><i class="bi bi-clock-history"></i> Recent Activity Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        @foreach($stats['recent_stores'] as $store)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-primary"></div>
                            <div class="timeline-content">
                                <h6>New Store Added: {{ $store->name }}</h6>
                                <small class="text-muted">{{ $store->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endforeach
                        
                        @foreach($stats['recent_products'] as $product)
                        <div class="timeline-item">
                            <div class="timeline-marker bg-success"></div>
                            <div class="timeline-content">
                                <h6>New Product: {{ $product->name }}</h6>
                                <small class="text-muted">{{ $product->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5><i class="bi bi-lightning"></i> Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2 flex-wrap">
                        <a href="{{ route('stores.create') }}" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Add Store
                        </a>
                        <a href="{{ route('products.create') }}" class="btn btn-success">
                            <i class="bi bi-plus-circle"></i> Add Product
                        </a>
                        <a href="{{ route('suppliers.create') }}" class="btn btn-info">
                            <i class="bi bi-plus-circle"></i> Add Supplier
                        </a>
                        <a href="{{ route('manufacturers.create') }}" class="btn btn-warning">
                            <i class="bi bi-plus-circle"></i> Add Manufacturer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM loaded, initializing charts...');
    
    // Stores Chart
    const storesCanvas = document.getElementById('storesChart');
    if (storesCanvas) {
        const storesCtx = storesCanvas.getContext('2d');
        new Chart(storesCtx, {
            type: 'bar',
            data: {
                labels: ['Total Stores', 'Stores with Products'],
                datasets: [{
                    label: 'Store Statistics',
                    data: [{{ $stats['total_stores'] }}, {{ $stats['stores_with_products'] }}],
                    backgroundColor: ['#007bff', '#28a745'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
        console.log('Stores chart initialized');
    } else {
        console.error('Stores chart canvas not found');
    }

    // Products Chart
    const productsCanvas = document.getElementById('productsChart');
    if (productsCanvas) {
        const productsCtx = productsCanvas.getContext('2d');
        new Chart(productsCtx, {
            type: 'pie',
            data: {
                labels: ['Total Products', 'Products Near Expiry'],
                datasets: [{
                    data: [{{ $stats['total_products'] }}, {{ $stats['products_near_expiry'] }}],
                    backgroundColor: ['#17a2b8', '#dc3545'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });
        console.log('Products chart initialized');
    } else {
        console.error('Products chart canvas not found');
    }
});
</script>

<style>
.timeline {
    position: relative;
    padding-left: 2rem;
}
.timeline-item {
    position: relative;
    padding-bottom: 1.5rem;
}
.timeline-marker {
    position: absolute;
    left: -2rem;
    width: 1rem;
    height: 1rem;
    border-radius: 50%;
    top: 0.25rem;
}
.timeline-content {
    padding-left: 1rem;
}
@media (max-width: 768px) {
    .display-6 {
        font-size: 1.5rem;
    }
    .card-body {
        padding: 1rem;
    }
    .btn {
        margin-bottom: 0.5rem;
    }
    .d-flex.gap-2 {
        gap: 0.5rem !important;
    }
}
</style>
@endsection