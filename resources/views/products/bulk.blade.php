@extends('layouts.app')

@section('title', 'Bulk Product Operations')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Bulk Product Operations</h2>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Products
        </a>
    </div>

    <div class="row">
        <!-- Import Section -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-upload me-2"></i>Import Products</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('products.bulk.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="csv_file" class="form-label">CSV File</label>
                            <input type="file" name="csv_file" class="form-control" accept=".csv" required>
                            <div class="form-text">
                                Download the <a href="{{ route('products.bulk.template') }}" class="text-primary">CSV template</a> for proper formatting
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <h6 class="alert-heading"><i class="bi bi-info-circle"></i> Import Instructions</h6>
                            <ul class="mb-0 ps-3">
                                <li>Use the provided template</li>
                                <li>Keep the header row</li>
                                <li>Date format: YYYY-MM-DD</li>
                                <li>Max file size: 5MB</li>
                            </ul>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-upload me-2"></i>Import Products
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Export Section -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="bi bi-download me-2"></i>Export Products</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Export all products to a CSV file. This file can be opened in Excel or any spreadsheet application.</p>
                    
                    <div class="mb-3">
                        <h6>Export includes:</h6>
                        <ul class="mb-0">
                            <li>Product details</li>
                            <li>Manufacturer information</li>
                            <li>Supplier information</li>
                            <li>Pricing and expiry dates</li>
                        </ul>
                    </div>

                    <a href="{{ route('products.bulk.export') }}" class="btn btn-success w-100" id="exportBtn">
                        <i class="bi bi-download me-2"></i>Export to CSV
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Imports Section -->
    @if(session('success') || session('error'))
    <div class="row">
        <div class="col-12">
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
        </div>
    </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add loading state to export button
    const exportBtn = document.getElementById('exportBtn');
    if (exportBtn) {
        exportBtn.addEventListener('click', function() {
            this.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Exporting...';
            this.classList.add('disabled');
        });
    }

    // Show file name when selected
    const fileInput = document.querySelector('input[type="file"]');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                const fileName = this.files[0].name;
                this.nextElementSibling.textContent = `Selected: ${fileName}`;
            }
        });
    }
});
</script>
@endsection