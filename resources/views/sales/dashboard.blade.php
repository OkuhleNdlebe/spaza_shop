{{-- resources/views/sales/dashboard.blade.php --}}
@extends('layouts.app')

@section('title', 'Sales Dashboard')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sales Dashboard</h2>
        <div>
            <a href="{{ route('sales.index') }}" class="btn btn-secondary me-2">
                <i class="bi bi-list"></i> All Sales
            </a>
            <a href="{{ route('sales.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> New Sale
            </a>
        </div>
    </div>

    <!-- Sales Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body text-center">
                    <h3>R{{ number_format($todaySales, 2) }}</h3>
                    <p>Today's Sales</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body text-center">
                    <h3>R{{ number_format($weekSales, 2) }}</h3>
                    <p>This Week</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body text-center">
                    <h3>R{{ number_format($monthSales, 2) }}</h3>
                    <p>This Month</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body text-center">
                    <h3>{{ $topProducts->sum('total_sold') }}</h3>
                    <p>Total Units Sold</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0">Top Selling Products</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Units Sold</th>
                                    <th>Revenue</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topProducts as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>{{ $item->total_sold }}</td>
                                    <td>R{{ number_format($item->total_sold * $item->product->price, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Recent Sales</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Time</th>
                                    <th>Product</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentSales as $sale)
                                <tr>
                                    <td>{{ $sale->sale_date->format('H:i') }}</td>
                                    <td>{{ $sale->product->name }}</td>
                                    <td>R{{ number_format($sale->total_amount, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Chart (Placeholder) -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Sales Trend</h5>
        </div>
        <div class="card-body">
            <div class="text-center py-5">
                <i class="bi bi-bar-chart" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Sales chart will be displayed here</p>
                <small>Integrate with Chart.js for visual analytics</small>
            </div>
        </div>
    </div>
</div>
@endsection