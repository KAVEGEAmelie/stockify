<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockMovementController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('categories', CategoryController::class);
Route::resource('suppliers', SupplierController::class);
Route::resource('products', ProductController::class);
Route::resource('stock-movements', StockMovementController::class);

// Routes additionnelles pour la gestion des stocks
Route::post('/products/{product}/stock-in', [ProductController::class, 'stockIn'])->name('products.stock-in');
Route::post('/products/{product}/stock-out', [ProductController::class, 'stockOut'])->name('products.stock-out');
Route::get('/products/low-stock', [ProductController::class, 'lowStock'])->name('products.low-stock');
