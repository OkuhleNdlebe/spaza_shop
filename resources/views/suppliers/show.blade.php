@extends('layouts.app')

@section('title', 'Supplier Details')

@section('content')
<div class="container">
    <div class="card shadow p-4">
        <h2 class="text-primary">{{ $supplier->company_name }}</h2>
        <p><strong>Contact Person:</strong> {{ $supplier->contact_person }}</p>
        <p><strong>Phone:</strong> {{ $supplier->phone_number }}</p>
        <p><strong>Email:</strong> {{ $supplier->email }}</p>
        <p><strong>Address:</strong> {{ $supplier->address }}</p>

        <h3>QR Code</h3>
        <div>{!! $qrcode !!}</div>

        <h3>Products</h3>
    </div>
</div>
@endsection
