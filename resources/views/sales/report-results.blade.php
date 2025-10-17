{{-- resources/views/sales/report-results.blade.php --}}
@extends('layouts.app')

@section('title', 'Sales Report Results')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sales Report Results</h2>
        <div>
            <a href="{{ route('sales.reports') }}" class="btn btn-secondary me-2">
                <i class="bi bi-arrow-left"></i> Back to Reports
            </a>
            <a href="{{ route('sales.reports') }}" class="btn btn-primary">
                <i class="bi bi-file-text"></i> New Report
            </a>
        </div>
    </div>

    <!-- Report Summary -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body text-center">
                    <h3>R{{ number_format($totalRevenue, 2) }}</h3>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body text-center">
                    <h3>{{ number_format($totalUnits) }}</h3>
                    <p>Total Units Sold</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-info">
                <div class="card-body text-center">
                    <h3>{{ $sales->count() }}</h3>
                    <p>Number of Sales</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Report Details -->
    <div class="card mb-4">
        <div class="card-header bg-secondary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Report Details</h5>
                <span class="badge bg-light text-dark">
                    {{ \Carbon\Carbon::parse($validated['start_date'])->format('M j, Y') }} 
                    - 
                    {{ \Carbon\Carbon::parse($validated['end_date'])->format('M j, Y') }}
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Date Range:</strong> 
                        {{ \Carbon\Carbon::parse($validated['start_date'])->format('F j, Y') }} 
                        to 
                        {{ \Carbon\Carbon::parse($validated['end_date'])->format('F j, Y') }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Duration:</strong> 
                        {{ \Carbon\Carbon::parse($validated['start_date'])->diffInDays($validated['end_date']) + 1 }} days
                    </p>
                </div>
            </div>
            
            @if(!empty($validated['store_id']))
            <p><strong>Store Filter:</strong> 
                {{ \App\Models\Store::find($validated['store_id'])->name }}
            </p>
            @endif
        </div>
    </div>

    <!-- Sales Data -->
    <div class="card">
        <div class="card-header bg-dark text-white">
            <h5 class="mb-0">Sales Data</h5>
        </div>
        <div class="card-body">
            @if($sales->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-primary">
                        <tr>
                            <th>Date</th>
                            <th>Store</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sales as $sale)
                        <tr>
                            <td>{{ $sale->sale_date->format('M j, Y H:i') }}</td>
                            <td>{{ $sale->store->name }}</td>
                            <td>{{ $sale->product->name }}</td>
                            <td>{{ $sale->quantity }}</td>
                            <td>R{{ number_format($sale->unit_price, 2) }}</td>
                            <td>R{{ number_format($sale->total_amount, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-info">
                        <tr>
                            <th colspan="3" class="text-end">Totals:</th>
                            <th>{{ $sales->sum('quantity') }}</th>
                            <th></th>
                            <th>R{{ number_format($sales->sum('total_amount'), 2) }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <!-- Export Options -->
            <div class="mt-4">
                <h6>Export Report:</h6>
                <div class="btn-group">
                    <a href="{{ route('sales.generate-report') }}?start_date={{ $validated['start_date'] }}&end_date={{ $validated['end_date'] }}&store_id={{ $validated['store_id'] }}&format=csv" 
                       class="btn btn-outline-success">
                        <i class="bi bi-file-earmark-spreadsheet"></i> CSV
                    </a>
                    <a href="{{ route('sales.generate-report') }}?start_date={{ $validated['start_date'] }}&end_date={{ $validated['end_date'] }}&store_id={{ $validated['store_id'] }}&format=pdf" 
                       class="btn btn-outline-danger">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </a>
                </div>
            </div>
            @else
            <div class="text-center py-5">
                <i class="bi bi-search" style="font-size: 3rem;"></i>
                <h5 class="mt-3">No sales found for this criteria</h5>
                <p class="text-muted">Try adjusting your date range or store filter</p>
                <a href="{{ route('sales.reports') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-arrow-repeat"></i> Try Different Criteria
                </a>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection