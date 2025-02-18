@extends('layouts.app')

@section('title', 'Store Details')

@section('content')
<div class="container mt-4">
    <div class="card shadow p-4">
        <h2 class="text-primary">{{ $store->name }}</h2>
        <p><strong>Location:</strong> {{ $store->location }}</p>
        <p><strong>Owner:</strong> {{ $store->owner_name }}</p>
        <p><strong>Contact:</strong> {{ $store->contact_number }}</p>

        <h3>QR Code</h3>
        <div>{!! $qrCode !!}</div> <!-- This will display the QR code -->

        <div class="mt-4">
            <a href="{{ route('stores.index') }}" class="btn btn-secondary">Back to Stores</a>
        </div>
    </div>
</div>
@endsection
