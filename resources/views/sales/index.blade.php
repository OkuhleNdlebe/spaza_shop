{{-- resources/views/sales/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Sales Records')

@section('content')
<div class="container" style="padding-top: 30px;"> {{-- ADDED PADDING TOP --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sales Records</h2>
        <div>
            <a href="{{ route('sales.create') }}" class="btn btn-primary me-2">
                <i class="bi bi-plus-circle"></i> Record Sale
            </a>
            <a href="{{ route('sales.dashboard') }}" class="btn btn-info me-2">
                <i class="bi bi-graph-up"></i> Sales Dashboard
            </a>
            <a href="{{ route('sales.reports') }}" class="btn btn-success">
                <i class="bi bi-file-text"></i> Reports
            </a>
        </div>
    </div>

    <!-- Summary Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body text-center">
                    <h3>R{{ number_format($totalSales, 2) }}</h3>
                    <p>Total Revenue</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body text-center">
                    <h3>{{ number_format($totalUnits) }}</h3>
                    <p>Total Units Sold</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body text-center">
                    <h3>{{ $sales->total() }}</h3>
                    <p>Total Transactions</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body text-center">
                    <h3>{{ $sales->count() }}</h3>
                    <p>This Page</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="card">
        <div class="card-header bg-secondary text-white">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Sales History</h5>
                <span>Showing {{ $sales->firstItem() }} to {{ $sales->lastItem() }} of {{ $sales->total() }} records</span>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Store</th>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sales as $sale)
                        <tr>
                            <td>{{ $sale->sale_date->format('M j, Y H:i') }}</td>
                            <td>{{ $sale->store->name }}</td>
                            <td>{{ $sale->product->name }}</td>
                            <td>{{ $sale->quantity }}</td>
                            <td>R{{ number_format($sale->unit_price, 2) }}</td>
                            <td>R{{ number_format($sale->total_amount, 2) }}</td>
                            <td>
                                <a href="{{ route('sales.show', $sale) }}" class="btn btn-sm btn-info" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('sales.edit', $sale) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('sales.destroy', $sale) }}" method="POST" style="display: inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" 
                                            onclick="return confirm('Delete this sale?')" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-4">
                                <div class="text-muted">
                                    <i class="bi bi-receipt" style="font-size: 3rem;"></i>
                                    <h5 class="mt-3">No sales records found</h5>
                                    <p>Start recording your first sale to see data here</p>
                                    <a href="{{ route('sales.create') }}" class="btn btn-primary mt-2">
                                        <i class="bi bi-plus-circle"></i> Record First Sale
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($sales->hasPages())
            <div class="d-flex justify-content-center mt-4">
                <nav>
                    {{ $sales->links() }}
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection