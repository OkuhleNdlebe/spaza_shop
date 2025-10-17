@extends('layouts.app')

@section('title', 'Advanced Reports')

@section('content')
<div class="container">
    <h2>Advanced Reporting</h2>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5>Sales Reports</h5>
                </div>
                <div class="card-body">
                    <p>Generate detailed sales reports by date range and store</p>
                    <a href="{{ route('reports.sales') }}" class="btn btn-primary">Generate Sales Report</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5>Inventory Reports</h5>
                </div>
                <div class="card-body">
                    <p>Stock levels, valuation, and inventory health</p>
                    <a href="{{ route('reports.inventory') }}" class="btn btn-success">View Inventory Report</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5>Supplier Performance</h5>
                </div>
                <div class="card-body">
                    <p>Analyze supplier delivery times and product quality</p>
                    <a href="{{ route('reports.suppliers') }}" class="btn btn-info">Supplier Reports</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection