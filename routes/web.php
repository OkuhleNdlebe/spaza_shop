<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\StoreController;

// Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
// Route::get('/stores/{id}', [StoreController::class, 'show'])->name('stores.show');
// Route::get('/stores/create', [StoreController::class, 'create'])->name('stores.create');

Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/stores/create', [StoreController::class, 'create'])->name('stores.create');
Route::post('/stores', [StoreController::class, 'store'])->name('stores.store');
Route::get('/stores/{id}', [StoreController::class, 'show'])->name('stores.show');
Route::get('/stores/{id}/qrcode', [StoreController::class, 'generateQRCode'])->name('stores.qrcode');

use App\Http\Controllers\SupplierController;

Route::resource('suppliers', SupplierController::class);

use App\Http\Controllers\ProductController;

Route::resource('products', ProductController::class);

use App\Http\Controllers\ManufacturerController;
Route::resource('manufacturers', ManufacturerController::class);

use App\Http\Controllers\StoreProductController;

Route::get('/stores/{store}/products/register', [StoreProductController::class, 'create'])->name('store_products.create');
Route::post('/stores/{store}/products/register', [StoreProductController::class, 'store'])->name('store_products.store');

use App\Http\Controllers\DashboardController;
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

use App\Http\Controllers\BulkProductController;
// Bulk product operations
Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');

// Reports
// routes/web.php
// Sales routes
use App\Http\Controllers\SaleController;
Route::resource('sales', SaleController::class);
Route::get('/sales-dashboard', [SaleController::class, 'dashboard'])->name('sales.dashboard');
Route::get('/sales-reports', [SaleController::class, 'reports'])->name('sales.reports');
Route::post('/sales-generate-report', [SaleController::class, 'generateReport'])->name('sales.generate-report');

// Predictive Analytics
use App\Http\Controllers\PredictiveAnalyticsController;
Route::get('/analytics', [PredictiveAnalyticsController::class, 'index'])->name('analytics.index');
Route::post('/analytics/predict', [PredictiveAnalyticsController::class, 'predict'])->name('analytics.predict');    
Route::get('/analytics/dashboard', [PredictiveAnalyticsController::class, 'dashboard'])->name('analytics.dashboard');  
Route::get('/generate-predictions', [PredictiveAnalyticsController::class, 'generatePredictions'])->name('analytics.generate');