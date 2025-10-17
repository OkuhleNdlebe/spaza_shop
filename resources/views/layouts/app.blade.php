<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Shop Guard')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        /* Root variables for colors and gradients */
:root {
    --bg-light: #f5f7fa;
    --bg-dark: #1f1f1f;
    --text-light: #f5f5f5;
    --text-dark: #333;
    --primary-color: #2E7D32; /* Changed from blue to green */
    --primary-hover: #1B5E20; /* Darker green for hover */
    --gradient-start: #2E7D32; /* Green gradient start */
    --gradient-end: #4CAF50; /* Green gradient end */
    --card-bg: #ffffff;
    --card-border: #e0e0e0;
}

/* Body setup with flexbox for footer */
body {
    background-color: var(--bg-light);
    font-family: 'Segoe UI', Arial, sans-serif;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    margin: 0;
    padding-top: 65px;
}

/* Container spacing */
.container {
    flex: 1;
    margin-top: 24px;
    padding-bottom: 30px;
}

/* Navbar - UPDATED COLORS */
.navbar {
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 9999;
    background: linear-gradient(90deg, var(--gradient-start) 0%, var(--gradient-end) 100%);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.13);
    padding-top: 6px;
    padding-bottom: 6px;
}
.navbar-brand {
    font-size: 1.6rem;
    font-weight: bold;
}
.navbar-nav .nav-link {
    font-size: 1rem;
    font-weight: 500;
    padding: 0.6rem 1rem;
    transition: color 0.3s ease;
}
/* Larger icons in navbar */
.navbar-nav .nav-link i {
    font-size: 1.3rem; /* Increased icon size */
    margin-right: 0.5rem;
    vertical-align: middle;
}
.navbar-nav .nav-link:hover {
    color: #e8f5e9 !important; /* Light green hover text */
    background-color: rgba(255, 255, 255, 0.1);
    border-radius: 6px;
}
.navbar-nav .nav-link.active {
    color: #ffffff !important;
    background-color: rgba(255, 255, 255, 0.2);
    border-radius: 6px;
    font-weight: 600;
}

/* User dropdown and icons */
.user-dropdown .user-avatar {
    width: 35px;
    height: 35px;
    background: linear-gradient(45deg, var(--gradient-start), var(--gradient-end));
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    margin-right: 0.5rem;
}
.text-light {
    color: rgba(255, 255, 255, 0.9) !important;
}
.text-light:hover {
    color: #ffffff !important;
}

/* Notification badge */
.notification-badge {
    position: absolute;
    top: -8px;
    right: -8px;
    background-color: #ff4757;
    color: white;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    font-size: 0.7rem;
    display: flex;
    align-items: center;
    justify-content: center;
}

/* Search form */
.search-form {
    margin-right: 1rem;
}
.search-form .form-control {
    border-radius: 20px 0 0 20px;
    border: none;
}
.search-form .btn {
    border-radius: 0 20px 20px 0;
    border: none;
}

/* Footer */
footer {
    position: relative;
    width: 100%;
    background: linear-gradient(90deg, #222 0%, #333 100%);
    color: var(--text-light);
    padding: 25px 0 15px 0;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.07);
}
footer h5 {
    font-size: 1.2rem;
    margin-bottom: 15px;
    font-weight: 600;
}
footer ul li {
    margin-bottom: 8px;
}
footer ul li a {
    text-decoration: none;
    color: #bbb;
    transition: color 0.3s ease;
}
footer ul li a:hover {
    color: #fff;
}
footer .text-center {
    margin-top: 15px;
    font-size: 0.9rem;
    color: #aaa;
}

/* Card Styles */
.card {
    background-color: var(--card-bg);
    border: 1px solid var(--card-border);
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    margin-bottom: 30px;
}
.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.12);
}
.card-header {
    background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
    color: #fff;
    font-weight: 600;
    border-radius: 12px 12px 0 0;
    padding: 12px 16px;
}
.card-body {
    padding: 20px;
}

/* Buttons - UPDATED TO GREEN */
.btn-primary {
    background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
    border: none;
    border-radius: 8px;
    font-weight: 600;
    padding: 10px 18px;
    transition: background 0.3s ease, transform 0.2s ease;
}
.btn-primary:hover {
    background: linear-gradient(90deg, var(--primary-hover), #3d8b40);
    transform: translateY(-2px);
}
.btn-outline-primary {
    border: 2px solid var(--gradient-start);
    color: var(--gradient-start);
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}
.btn-outline-primary:hover {
    background: var(--gradient-start);
    color: #fff;
}

/* Forms */
.form-control {
    border-radius: 8px;
    border: 1px solid #ccc;
    padding: 10px 12px;
    transition: border-color 0.3s ease, box-shadow 0.3s ease;
}
.form-control:focus {
    border-color: var(--gradient-start);
    box-shadow: 0 0 6px rgba(46, 125, 50, 0.2);
}

/* Alerts */
.alert {
    border-radius: 8px;
    font-weight: 500;
    padding: 12px 16px;
}

/* Tables */
.table {
    border-radius: 8px;
    overflow: hidden;
    background: #fff;
}
.table thead {
    background: linear-gradient(90deg, var(--gradient-start), var(--gradient-end));
    color: #fff;
}
.table-striped tbody tr:nth-of-type(odd) {
    background-color: #f9fbfd;
}
.table-hover tbody tr:hover {
    background-color: #eef5ff;
}
.footer-content {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    gap: 2rem;
    margin-bottom: 2rem;
}

.footer-section {
    flex: 1;
    min-width: 250px;
    margin-bottom: 1rem;
}

/* Utility Classes */
.shadow-sm { box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06) !important; }
.shadow-lg { box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12) !important; }
.rounded-lg { border-radius: 12px !important; }
.rounded-xl { border-radius: 20px !important; }

/* Responsive tweaks */
@media (max-width: 768px) {
    .navbar-nav .nav-link {
        padding: 0.8rem 1rem;
    }
    .navbar-nav .nav-link i {
        font-size: 1.2rem;
    }
    .card-body {
        padding: 16px;
    }
    footer {
        text-align: center;
    }
    footer .row > div {
        margin-bottom: 20px;
    }
    .search-form {
        margin: 1rem 0;
    }
}
    </style>
</head>
<body>
    <!-- Navbar - UPDATED WITH LARGER ICONS -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-shop-window me-2" style="font-size: 1.8rem;"></i>Shop Guard
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="bi bi-house-door"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('stores.*') ? 'active' : '' }}" href="{{ route('stores.index') }}">
                            <i class="bi bi-shop"></i> Stores
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}">
                            <i class="bi bi-truck"></i> Suppliers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('manufacturers.*') ? 'active' : '' }}" href="{{ route('manufacturers.index') }}">
                            <i class="bi bi-buildings"></i> Manufacturers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
                            <i class="bi bi-box-seam"></i> Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}" href="{{ route('sales.index') }}">
                            <i class="bi bi-cash-coin"></i> Sales
                        </a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('analytics.*') ? 'active' : '' }}" href="{{ route('analytics.dashboard') }}">
                        <i class="bi bi-graph-up-arrow"></i> Analytics
                    </a>
                </li>
                </ul>
                
                <form class="search-form d-none d-md-flex">
                    <input class="form-control" type="search" placeholder="Search..." aria-label="Search">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                
                <div class="d-flex gap-3 align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-plus-circle" style="font-size: 1.2rem;"></i> Quick Add
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('stores.create') }}"><i class="bi bi-shop"></i> Store</a></li>
                            <li><a class="dropdown-item" href="{{ route('suppliers.create') }}"><i class="bi bi-truck"></i> Supplier</a></li>
                            <li><a class="dropdown-item" href="{{ route('manufacturers.create') }}"><i class="bi bi-buildings"></i> Manufacturer</a></li>
                            <li><a class="dropdown-item" href="{{ route('products.create') }}"><i class="bi bi-box-seam"></i> Product</a></li>
                        </ul>
                    </div>
                    
                    <a href="#" class="text-light position-relative d-none d-md-block">
                        <i class="bi bi-bell" style="font-size: 1.3rem;"></i>
                        <span class="notification-badge">3</span>
                    </a>
                    
                    <!-- <div class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle text-light text-decoration-none d-flex align-items-center" data-bs-toggle="dropdown">
                            <div class="user-avatar">O</div>
                            <span class="d-none d-lg-inline ms-2">Okuhle Ndlebe</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> Profile</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                        </ul>
                    </div> -->
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <!-- Breadcrumb Navigation -->
        <div class="breadcrumb-container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/') }}"><i class="bi bi-house-door"></i> Home</a></li>
                    @yield('breadcrumb', '')
                </ol>
            </nav>
        </div>
        
        @yield('content')
    </div>

    <!-- Notification Toast -->
    <!-- <div class="toast notification-toast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="true" data-bs-delay="5000">
        <div class="toast-header">
            <i class="bi bi-bell text-primary me-2"></i>
            <strong class="me-auto">Notification</strong>
            <small>Just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            Welcome back! You have 3 new notifications.
        </div>
    </div> -->

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h5>Shop Guard</h5>
                    <p>Comprehensive inventory management system for retail businesses. Track products, suppliers, and stores in one place.</p>
                    <div class="social-links">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h5>Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ url('/') }}"><i class="bi bi-house-door"></i> Home</a></li>
                        <li><a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a></li>
                        <li><a href="{{ route('stores.index') }}"><i class="bi bi-shop"></i> Stores</a></li>
                        <li><a href="{{ route('suppliers.index') }}"><i class="bi bi-truck"></i> Suppliers</a></li>
                        <li><a href="{{ route('manufacturers.index') }}"><i class="bi bi-buildings"></i> Manufacturers</a></li>
                        <li><a href="{{ route('products.index') }}"><i class="bi bi-box-seam"></i> Products</a></li>
                        <li><a href="{{ route('sales.index') }}"><i class="bi bi-cash-coin"></i> Sales</a></li> 
                        
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h5>Resources</h5>
                    <ul class="footer-links">
                        <li><a href="#"><i class="bi bi-file-text"></i> Documentation</a></li>
                        <li><a href="#"><i class="bi bi-question-circle"></i> Help Center</a></li>
                        <li><a href="#"><i class="bi bi-collection-play"></i> Tutorials</a></li>
                        <li><a href="#"><i class="bi bi-chat-left-text"></i> FAQs</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h5>Contact Us</h5>
                    <ul class="footer-links">
                        <li><a href="mailto:okuhlendlebe0@gmail.com"><i class="bi bi-envelope"></i> okuhlendlebe0@gmail.com</a></li>
                        <li><a href="#"><i class="bi bi-telephone"></i> +27 123 456 789</a></li>
                        <li><a href="#"><i class="bi bi-geo-alt"></i> Cape Town, South Africa</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>
                    &copy; 2025 Shop Guard | 
                    <a href="mailto:okuhlendlebe0@gmail.com"><i class="bi bi-envelope-at"></i> Contact Us</a>
                </p>
                <p>
                    Capstone Project by <span style="color:#4CAF50">Okuhle Ndlebe</span>
                </p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastEl = document.querySelector('.notification-toast');
            if (toastEl) {
                var toast = new bootstrap.Toast(toastEl);
                setTimeout(function() {
                    toast.show();
                }, 1000);
            }
            
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
    
    @yield('scripts')
</body>
</html>