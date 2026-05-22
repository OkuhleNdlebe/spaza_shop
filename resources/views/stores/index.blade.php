@extends('layouts.app')

@section('title', 'Spaza Stores')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary mb-0">Spaza Stores</h1>
        <a href="{{ route('stores.create') }}" class="btn btn-success">
            <i class="bi bi-plus-circle"></i> Add New Store
        </a>
    </div>
    
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    @if($stores->count() > 0)
    <div class="row mt-4">
        @foreach($stores as $store)
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $store->name }}</h5>
                        <p class="card-text"><strong>Location:</strong> {{ $store->location }}</p>
                        <p class="card-text"><strong>Owner:</strong> {{ $store->owner_name }}</p>
                        <p class="card-text"><strong>Contact:</strong> {{ $store->contact_number }}</p>
                        <div class="d-flex gap-2">
                            <a href="{{ route('stores.show', $store->id) }}" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i> View Details
                            </a>
                            <a href="{{ route('stores.edit', $store->id) }}" class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-4">
        {{ $stores->links() }}
    </div>
    @else
    <div class="alert alert-info text-center py-5">
        <i class="bi bi-shop" style="font-size: 3rem;"></i>
        <h4 class="mt-3">No Stores Found</h4>
        <p class="text-muted">Get started by adding your first store.</p>
        <a href="{{ route('stores.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add Your First Store
        </a>
    </div>
    @endif
</div>
@endsection