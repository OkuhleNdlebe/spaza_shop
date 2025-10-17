@extends('layouts.app')

@section('title', 'Spaza Stores')

@section('content')
<div class="container mt-4">
    <h1 class="text-primary text-center">Spaza Stores</h1>
    
    <div class="row mt-4">
        @foreach($stores as $store)
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $store->name }}</h5>
                        <p class="card-text"><strong>Location:</strong> {{ $store->location }}</p>
                        <p class="card-text"><strong>Owner:</strong> {{ $store->owner_name }}</p>
                        <a href="{{ route('stores.show', $store->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
        <!-- After the stores loop -->
<div class="mt-4">
    {{ $stores->links() }}
</div>
    </div>
</div>
@endsection
