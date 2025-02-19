<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Spaza Shop')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
            padding-top: 70px; /* To avoid content being hidden under fixed navbar */
            padding-bottom: 70px; /* To ensure footer doesn't overlap content */
        }
        .container {
            margin-top: 20px;
        }

        /* Navbar Styling */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 9999; /* Keep navbar on top */
            background-color: #004D40; /* Dark teal background */
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Subtle shadow */
            transition: all 0.3s ease; /* Smooth transition on hover */
        }

        .navbar:hover {
            background-color: #00332D; /* Darker teal on hover */
        }

        .navbar-brand {
            font-size: 1.8rem;
            font-weight: bold;
            color: #FFFFFF; /* White text */
            text-transform: uppercase;
        }

        .navbar-brand:hover {
            color: #ff5c5c; /* Soft red on hover */
        }

        .navbar-nav .nav-link {
            font-size: 1.1rem;
            color: #f1f1f1; /* Light gray text */
            padding: 12px 20px;
            transition: all 0.3s ease;
        }

        .navbar-nav .nav-link:hover {
            color: #ff5c5c; /* Soft red color on hover */
            background-color: #00332D; /* Slight background change */
            border-radius: 5px; /* Rounded edges for hover effect */
        }

        .navbar-toggler {
            border-color: #ff5c5c;
        }

        .navbar-toggler-icon {
            background-color: #ff5c5c;
        }

        /* Footer Styling */
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 20px 0;
            z-index: 9999;
        }

        footer a {
            color: #ff5c5c;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        footer p {
            margin: 0;
        }

        /* Additional refinements */
        .btn-primary {
            background-color: #ff5c5c; /* Soft red button */
            border-color: #ff5c5c;
        }

        .btn-primary:hover {
            background-color: #e04747; /* Slightly darker red on hover */
            border-color: #e04747;
        }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Spaza Shop</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('stores.index') }}">Stores</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('suppliers.index') }}">Suppliers</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('products.index') }}">Products</a></li>
                </ul>
                <a href="{{ route('stores.create') }}" class="btn btn-primary">Create a Shop</a>
            </div>
        </div>
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Spaza Shop | <a href="mailto:info@spazashop.com">Contact Us</a></p>
        <p>Capstone Project by Okuhle Ndlebe</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
