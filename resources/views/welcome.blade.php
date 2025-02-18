@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="text-center">
    <h1 class="text-success">Welcome to Spaza Shop Management</h1>
    <p>Track and manage stores efficiently.</p>
    <p>Our platform allows you to create, manage, and track the stores in your local community. With Spaza Shop Management, you can ensure that each store is verified, monitor product details, and generate QR codes for easy access to product information. This helps improve the overall shopping experience while ensuring safety and authenticity for your customers.</p>
    <a href="{{ route('stores.index') }}" class="btn btn-success">View Stores</a>
</div>

<div class="container mt-5">
    <div class="row">
        <!-- Card 1: Store Management -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="card-title">Store Management</h5>
                    <p class="card-text">Easily create and manage stores within the system. Track the details of each shop and ensure their authenticity.</p>
                </div>
            </div>
        </div>

        <!-- Card 2: Product Verification -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="card-title">Product Verification</h5>
                    <p class="card-text">Ensure that only verified products are sold in your stores, protecting your customers from counterfeit goods.</p>
                </div>
            </div>
        </div>

        <!-- Card 3: QR Code Generation -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="card-title">QR Code Generation</h5>
                    <p class="card-text">Generate QR codes for your products for easy access to detailed information. Increase transparency and trust with your customers.</p>
                </div>
            </div>
        </div>

        <!-- Card 4: Data Analytics -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="card-title">Data Analytics</h5>
                    <p class="card-text">Get insightful data about your stores, product trends, and customer preferences to help you make informed business decisions.</p>
                </div>
            </div>
        </div>

        <!-- Card 5: Community Engagement -->
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <h5 class="card-title">Community Engagement</h5>
                    <p class="card-text">Build a stronger connection with your local community by providing reliable and safe products, ensuring the well-being of your customers.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
