<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\StoreProductController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BulkProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\PredictiveAnalyticsController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\FloatingChatbotController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Welcome Page
Route::get('/', function () {
    return view('welcome');
});

// =============================================
// STORE ROUTES
// =============================================
Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
Route::get('/stores/create', [StoreController::class, 'create'])->name('stores.create');
Route::post('/stores', [StoreController::class, 'store'])->name('stores.store');
Route::get('/stores/{id}', [StoreController::class, 'show'])->name('stores.show');
Route::get('/stores/{id}/edit', [StoreController::class, 'edit'])->name('stores.edit');
Route::put('/stores/{id}', [StoreController::class, 'update'])->name('stores.update');
Route::delete('/stores/{id}', [StoreController::class, 'destroy'])->name('stores.destroy');
Route::get('/stores/{id}/qrcode', [StoreController::class, 'generateQRCode'])->name('stores.qrcode');

// =============================================
// SUPPLIER ROUTES (Full Resource)
// =============================================
Route::resource('suppliers', SupplierController::class);

// =============================================
// MANUFACTURER ROUTES (Full Resource)
// =============================================
Route::resource('manufacturers', ManufacturerController::class);

// =============================================
// PRODUCT ROUTES
// =============================================
Route::resource('products', ProductController::class);
Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');

// =============================================
// BULK PRODUCT OPERATIONS
// =============================================
Route::get('/products/bulk', [BulkProductController::class, 'index'])->name('products.bulk');
Route::post('/products/bulk/import', [BulkProductController::class, 'import'])->name('products.bulk.import');
Route::get('/products/bulk/export', [BulkProductController::class, 'export'])->name('products.bulk.export');
Route::get('/products/bulk/template', [BulkProductController::class, 'downloadTemplate'])->name('products.bulk.template');

// =============================================
// STORE PRODUCT ROUTES (Assign products to stores)
// =============================================
Route::get('/stores/{store}/products/register', [StoreProductController::class, 'create'])->name('store_products.create');
Route::post('/stores/{store}/products/register', [StoreProductController::class, 'store'])->name('store_products.store');

// =============================================
// DASHBOARD ROUTES
// =============================================
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// =============================================
// SALES ROUTES
// =============================================
Route::resource('sales', SaleController::class);
Route::get('/sales-dashboard', [SaleController::class, 'dashboard'])->name('sales.dashboard');
Route::get('/sales-reports', [SaleController::class, 'reports'])->name('sales.reports');
Route::post('/sales-generate-report', [SaleController::class, 'generateReport'])->name('sales.generate-report');

// =============================================
// PREDICTIVE ANALYTICS ROUTES (FIXED)
// =============================================
// Dashboard view (GET)
Route::get('/analytics/dashboard', [PredictiveAnalyticsController::class, 'dashboard'])->name('analytics.dashboard');

// Generate predictions (POST - FIXED FROM GET TO POST)
Route::post('/generate-predictions', [PredictiveAnalyticsController::class, 'generatePredictions'])->name('analytics.generate');
// Create sample data for testing (GET)
Route::get('/analytics/sample', [PredictiveAnalyticsController::class, 'createSamplePredictions'])->name('analytics.sample');

// Redirect /analytics to dashboard
Route::get('/analytics', function() {
    return redirect()->route('analytics.dashboard');
});

// =============================================
// REPORT ROUTES
// =============================================
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/sales', [ReportController::class, 'generateSalesReport'])->name('reports.sales');
Route::get('/reports/inventory', [ReportController::class, 'inventoryReport'])->name('reports.inventory');

// =============================================
// CHATBOT ROUTES
// =============================================
Route::get('/chatbot', [ChatbotController::class, 'index'])->name('chatbot.index');
Route::post('/chatbot/send', [ChatbotController::class, 'sendMessage'])->name('chatbot.send');
Route::post('/chatbot/clear', [ChatbotController::class, 'clearConversation'])->name('chatbot.clear');

// =============================================
//Floating chatbot widget route
// =============================================
// Floating Chatbot Routes

Route::post('/chatbot/send', [FloatingChatbotController::class, 'sendMessage'])->name('chatbot.send');
Route::post('/chatbot/clear', [FloatingChatbotController::class, 'clearConversation'])->name('chatbot.clear');
Route::get('/chatbot/unread', [FloatingChatbotController::class, 'getUnreadCount'])->name('chatbot.unread');