{{-- resources/views/sales/reports.blade.php --}}
@extends('layouts.app')

@section('title', 'Sales Reports')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Sales Reports</h2>
        <a href="{{ route('sales.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Sales
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Generate Sales Report</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('sales.generate-report') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Start Date *</label>
                                    <input type="date" name="start_date" class="form-control" 
                                           value="{{ old('start_date', now()->subDays(30)->format('Y-m-d')) }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">End Date *</label>
                                    <input type="date" name="end_date" class="form-control" 
                                           value="{{ old('end_date', now()->format('Y-m-d')) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Store (Optional)</label>
                            <select name="store_id" class="form-select">
                                <option value="">All Stores</option>
                                @foreach($stores as $store)
                                <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
                                    {{ $store->name }} - {{ $store->location }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Report Format</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format" id="format-html" value="html" checked>
                                <label class="form-check-label" for="format-html">
                                    Web View (HTML)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format" id="format-csv" value="csv">
                                <label class="form-check-label" for="format-csv">
                                    Download CSV
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="format" id="format-pdf" value="pdf">
                                <label class="form-check-label" for="format-pdf">
                                    Download PDF
                                </label>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-file-text"></i> Generate Report
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Quick Reports</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('sales.generate-report') }}?start_date={{ now()->subDays(7)->format('Y-m-d') }}&end_date={{ now()->format('Y-m-d') }}&format=html" 
                           class="btn btn-outline-primary text-start">
                            <i class="bi bi-calendar-week"></i> Last 7 Days
                        </a>
                        <a href="{{ route('sales.generate-report') }}?start_date={{ now()->startOfMonth()->format('Y-m-d') }}&end_date={{ now()->format('Y-m-d') }}&format=html" 
                           class="btn btn-outline-success text-start">
                            <i class="bi bi-calendar-month"></i> This Month
                        </a>
                        <a href="{{ route('sales.generate-report') }}?start_date={{ now()->subDays(30)->format('Y-m-d') }}&end_date={{ now()->format('Y-m-d') }}&format=html" 
                           class="btn btn-outline-info text-start">
                            <i class="bi bi-calendar-range"></i> Last 30 Days
                        </a>
                        <a href="{{ route('sales.generate-report') }}?start_date={{ now()->startOfYear()->format('Y-m-d') }}&end_date={{ now()->format('Y-m-d') }}&format=html" 
                           class="btn btn-outline-warning text-start">
                            <i class="bi bi-calendar-year"></i> This Year
                        </a>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Report Tips</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-lightbulb text-warning"></i>
                            <small>Use date ranges to analyze sales trends</small>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-lightbulb text-warning"></i>
                            <small>Filter by store to compare performance</small>
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-lightbulb text-warning"></i>
                            <small>Download CSV for data analysis in Excel</small>
                        </li>
                        <li>
                            <i class="bi bi-lightbulb text-warning"></i>
                            <small>Use PDF for printable reports</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection