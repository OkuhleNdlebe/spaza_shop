@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<style>
    .welcome-row {
        display: flex;
        flex-wrap: wrap;
        gap: 2rem;
        justify-content: center;
        margin-bottom: 2.5rem;
    }
    .big-card {
        flex: 1 1 380px;
        max-width: 520px;
        min-width: 270px;
        box-shadow: 0 6px 32px rgba(25, 135, 84, 0.09);
        border: none;
        border-radius: 1.3rem;
        padding: 2.2rem 2.2rem 2.2rem 2.2rem;
        background: linear-gradient(120deg, #eafaf1 0%, #f8f9fa 100%);
        margin-bottom: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 180px;
    }
    .big-card-title {
        font-size: 2rem;
        font-weight: 700;
        color: #198754;
        margin-bottom: 1.1rem;
        letter-spacing: 1px;
        text-shadow: 0 2px 12px rgba(25, 135, 84, 0.1);
    }
    .big-card-lead {
        font-size: 1.13rem;
        font-weight: 500;
        color: #444;
        margin-bottom: 0.6rem;
    }
    .big-card-desc {
        color: #555;
        font-size: 1.03rem;
        margin-bottom: 0;
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
        line-height: 1.6;
    }
    @media (max-width: 1000px) {
        .welcome-row { flex-direction: column; gap: 1.6rem; }
        .big-card { max-width: 100%; }
    }

    /* Feature Cards */
    .feature-row {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        justify-content: center;
    }
    .feature-col {
        flex: 1 1 375px;
        max-width: 475px;
        min-width: 300px;
        margin-bottom: 1.2rem;
    }
    .feature-card {
        transition: transform 0.15s, box-shadow 0.15s;
        cursor: pointer;
        border: none;
        border-radius: 0.75rem;
        text-decoration: none !important;
        color: inherit;
        min-height: 68px;
        display: flex;
        align-items: center;
        padding: 0.7rem 1.2rem;
        box-shadow: 0 3px 18px rgba(25,135,84,0.07);
        background: #fff;
    }
    .feature-card:hover {
        transform: translateY(-4px) scale(1.015);
        box-shadow: 0 6px 24px rgba(0,0,0,0.11);
        background: #f7fcf9;
    }
    .feature-icon {
        font-size: 2.1rem;
        margin-right: 1.25rem;
        color: #198754;
        flex-shrink: 0;
    }
    .feature-info {
        text-align: left;
    }
    .feature-title {
        font-weight: 600;
        font-size: 1.13rem;
        margin-bottom: 2px;
    }
    .feature-desc {
        font-size: 0.99rem;
        color: #666;
        margin-bottom: 0;
        line-height: 1.3;
    }
    @media (max-width: 700px) {
        .feature-col { max-width: 100%; min-width: 0; }
        .feature-card { flex-direction: column; align-items: flex-start; padding: 1.1rem 1rem; }
        .feature-icon { margin-right: 0; margin-bottom: 0.5rem; }
        .feature-info { text-align: left; }
    }
</style>

<div class="welcome-row">
    <div class="big-card text-center">
        <div class="big-card-title">Welcome to Spaza Shop Management</div>
        <div class="big-card-lead">
            Effortlessly track, verify, and manage all your local stores, products, suppliers, and manufacturers.
        </div>
    </div>
    <div class="big-card text-center">
        <div class="big-card-desc">
            Spaza Shop Management empowers you to organize your local commerce community.<br>
            Seamlessly create and manage stores, monitor detailed product information, and link suppliers and manufacturers for full traceability.<br>
            Generate QR codes for instant product verification, helping you enhance customer trust and ensure the authenticity of every item.<br>
            Strengthen your business and community with a modern, transparent solution.
        </div>
    </div>
</div>

<div class="container">
    <div class="feature-row">
        <!-- Store Management -->
        <div class="feature-col">
            <a href="{{ route('stores.index') }}" class="feature-card shadow h-100">
                <span class="feature-icon"><i class="bi bi-shop"></i></span>
                <span class="feature-info">
                    <span class="feature-title">Stores</span><br>
                    <span class="feature-desc">
                        Create and manage stores. Track details and verify authenticity.
                    </span>
                </span>
            </a>
        </div>
        <!-- Product Management -->
        <div class="feature-col">
            <a href="{{ route('products.index') }}" class="feature-card shadow h-100">
                <span class="feature-icon"><i class="bi bi-box-seam"></i></span>
                <span class="feature-info">
                    <span class="feature-title">Products</span><br>
                    <span class="feature-desc">
                        Add, edit, and verify products. Ensure quality and authenticity.
                    </span>
                </span>
            </a>
        </div>
        <!-- Supplier Management -->
        <div class="feature-col">
            <a href="{{ route('suppliers.index') }}" class="feature-card shadow h-100">
                <span class="feature-icon"><i class="bi bi-truck"></i></span>
                <span class="feature-info">
                    <span class="feature-title">Suppliers</span><br>
                    <span class="feature-desc">
                        Manage suppliers and their products for smooth supply chain operations.
                    </span>
                </span>
            </a>
        </div>
        <!-- Manufacturer Management -->
        <div class="feature-col">
            <a href="{{ route('manufacturers.index') }}" class="feature-card shadow h-100">
                <span class="feature-icon"><i class="bi bi-buildings"></i></span>
                <span class="feature-info">
                    <span class="feature-title">Manufacturers</span><br>
                    <span class="feature-desc">
                        Track manufacturers and link them to your products for traceability.
                    </span>
                </span>
            </a>
        </div>
        <!-- QR Code Generation -->
        <div class="feature-col">
            <a href="{{ route('products.index') }}" class="feature-card shadow h-100">
                <span class="feature-icon"><i class="bi bi-qr-code"></i></span>
                <span class="feature-info">
                    <span class="feature-title">QR Codes</span><br>
                    <span class="feature-desc">
                        Generate QR codes for products for fast access to product info.
                    </span>
                </span>
            </a>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
@endsection