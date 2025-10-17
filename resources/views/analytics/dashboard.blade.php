@extends('layouts.app')

@section('title', 'Predictive Analytics')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Predictive Analytics Dashboard</h2>
        <form action="{{ route('analytics.generate') }}" method="POST" class="d-inline">
            @csrf
            <button type="submit" class="btn btn-primary" onclick="showLoading()">
                <i class="bi bi-arrow-repeat"></i> Generate Predictions
            </button>
        </form>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        <i class="bi bi-exclamation-triangle me-2"></i>
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($predictions->isEmpty() && $forecasts->isEmpty())
    <div class="card">
        <div class="card-body text-center py-5">
            <i class="bi bi-graph-up" style="font-size: 3rem; color: #6c757d;"></i>
            <h4 class="mt-3">No Analytics Data Available</h4>
            <p class="text-muted">Generate predictions to see analytics data.</p>
            <form action="{{ route('analytics.generate') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-arrow-repeat"></i> Generate Initial Predictions
                </button>
            </form>
        </div>
    </div>
    @else
    <div class="row">
        <!-- Sales Predictions -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Sales Predictions (Next 7 Days)</h5>
                </div>
                <div class="card-body">
                    @if($predictions->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Store</th>
                                    <th>Predicted</th>
                                    <th>Confidence</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($predictions->take(7) as $prediction)
                                <tr>
                                    <td>{{ $prediction->product->name ?? 'N/A' }}</td>
                                    <td>{{ $prediction->store->name ?? 'N/A' }}</td>
                                    <td>{{ $prediction->predicted_quantity }}</td>
                                    <td>
                                        <div class="progress" style="height: 10px;">
                                            <div class="progress-bar bg-success" 
                                                 style="width: {{ $prediction->confidence_level * 100 }}%">
                                            </div>
                                        </div>
                                        <small>{{ number_format($prediction->confidence_level * 100, 1) }}%</small>
                                    </td>
                                    <td>
                                        {{-- FIX: Use Carbon to parse the date string --}}
                                        {{ \Carbon\Carbon::parse($prediction->for_date)->format('M j') }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted text-center">No sales predictions available.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Inventory Risk Alerts -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5>Stockout Risk Alerts</h5>
                </div>
                <div class="card-body">
                    @if($forecasts->isNotEmpty())
                    <div class="table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Store</th>
                                    <th>Current</th>
                                    <th>Predicted</th>
                                    <th>Risk</th>
                                    <th>Recommend</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($forecasts as $forecast)
                                <tr class="@if($forecast->stockout_probability > 0.7) table-danger @endif">
                                    <td>{{ $forecast->product->name ?? 'N/A' }}</td>
                                    <td>{{ $forecast->store->name ?? 'N/A' }}</td>
                                    <td>{{ $forecast->current_stock }}</td>
                                    <td>{{ $forecast->predicted_demand }}</td>
                                    <td>
                                        <span class="badge bg-@if($forecast->stockout_probability > 0.7)danger
                                            @elseif($forecast->stockout_probability > 0.4)warning
                                            @else success @endif">
                                            {{ number_format($forecast->stockout_probability * 100, 0) }}%
                                        </span>
                                    </td>
                                    <td>{{ $forecast->recommended_order }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <p class="text-muted text-center">No stockout risks detected.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Demand Forecasting</h5>
                </div>
                <div class="card-body">
                    @if($predictions->isNotEmpty())
                    <canvas id="demandForecastChart" height="100"></canvas>
                    @else
                    <p class="text-muted text-center">No data available for chart.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
function showLoading() {
    const btn = event.target;
    btn.innerHTML = '<i class="bi bi-hourglass-split"></i> Generating...';
    btn.disabled = true;
    setTimeout(() => {
        btn.innerHTML = '<i class="bi bi-arrow-repeat"></i> Generate Predictions';
        btn.disabled = false;
    }, 5000);
}

// Simple chart implementation
document.addEventListener('DOMContentLoaded', function() {
    const chartCanvas = document.getElementById('demandForecastChart');
    if (chartCanvas) {
        const ctx = chartCanvas.getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'],
                datasets: [{
                    label: 'Predicted Sales',
                    data: [12, 19, 15, 17, 14, 16, 18],
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
</script>
@endsection