@extends('layouts.app')

@section('title', 'Manufacturers')

@section('content')
<div class="container mt-4">
    <h1 class="text-primary text-center">Manufacturers</h1>
    <a href="{{ route('manufacturers.create') }}" class="btn btn-success mb-3">Add Manufacturer</a>
    <div class="row mt-4">
        @foreach($manufacturers as $manufacturer)
            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title">{{ $manufacturer->name }}</h5>
                        <p class="card-text">{{ $manufacturer->contact_email }}</p>
                        <a href="{{ route('manufacturers.show', $manufacturer->id) }}" class="btn btn-primary">View Details</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection