@extends('layouts.app')

@section('title', $manufacturer->name)

@section('content')
<div class="container">
    <h1>{{ $manufacturer->name }}</h1>
    <p>Email: {{ $manufacturer->contact_email }}</p>
    <p>Website: <a href="{{ $manufacturer->website }}">{{ $manufacturer->website }}</a></p>
    <p>Address: {{ $manufacturer->address }}</p>
    <h3>QR Code</h3>
    {!! $qrcode !!}
    <h2 class="mt-4">Products</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Expiry Date</th>
                <th>Price</th>
                <th>Supplier</th>
            </tr>
        </thead>
        <tbody>
            @foreach($manufacturer->products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->expiry_date }}</td>
                <td>{{ $product->price }}</td>
                <td>{{ $product->supplier->company_name ?? '' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection