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
