<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ReportController;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Gestion des données de base
Route::resource('categories', CategoryController::class);
Route::resource('suppliers', SupplierController::class);
Route::get('/suppliers/export', [SupplierController::class, 'export'])->name('suppliers.export');
Route::get('/api/suppliers/search', [SupplierController::class, 'search'])->name('api.suppliers.search');
Route::resource('products', ProductController::class);
Route::resource('locations', LocationController::class);
Route::resource('tags', TagController::class);
Route::resource('custom-fields', CustomFieldController::class);

// Gestion des stocks
Route::resource('stock-movements', StockMovementController::class);
Route::get('/api/stock-movements/search', [StockMovementController::class, 'search'])->name('api.stock-movements.search');
Route::get('/api/stock-movements/stats', [StockMovementController::class, 'stats'])->name('api.stock-movements.stats');

// Routes additionnelles pour la gestion des stocks
Route::post('/products/{product}/stock-in', [ProductController::class, 'stockIn'])->name('products.stock-in');
Route::post('/products/{product}/stock-out', [ProductController::class, 'stockOut'])->name('products.stock-out');
Route::get('/products/low-stock', [ProductController::class, 'lowStock'])->name('products.low-stock');

// Upload d'images pour les produits
Route::post('/products/{product}/images', [ProductController::class, 'uploadImages'])->name('products.upload-images');
Route::delete('/products/images/{image}', [ProductController::class, 'deleteImage'])->name('products.delete-image');
Route::post('/products/images/{image}/set-primary', [ProductController::class, 'setPrimaryImage'])->name('products.set-primary-image');

// Gestion des tags et emplacements
Route::get('/api/tags/search', [TagController::class, 'search'])->name('api.tags.search');
Route::get('/api/locations/hierarchy', [LocationController::class, 'hierarchy'])->name('api.locations.hierarchy');

// Inventaire
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory.index');
Route::get('/inventory/count', [InventoryController::class, 'count'])->name('inventory.count');
Route::post('/inventory/adjust', [InventoryController::class, 'adjust'])->name('inventory.adjust');
Route::get('/inventory/scan', [InventoryController::class, 'scan'])->name('inventory.scan');

// Rapports
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
Route::get('/reports/stock-valuation', [ReportController::class, 'stockValuation'])->name('reports.stock-valuation');
Route::get('/reports/stock-rotation', [ReportController::class, 'stockRotation'])->name('reports.stock-rotation');
Route::get('/reports/low-stock', [ReportController::class, 'lowStock'])->name('reports.low-stock');

// Export / Import
Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
Route::get('/stock-movements/export/{product}', [StockMovementController::class, 'export'])->name('stock-movements.export');

// API pour codes-barres et QR codes
Route::post('/products/{product}/generate-qr', [ProductController::class, 'generateQrCode'])->name('products.generate-qr');
Route::get('/api/products/search', [ProductController::class, 'search'])->name('api.products.search');
Route::get('/api/products/barcode/{barcode}', [ProductController::class, 'findByBarcode'])->name('api.products.barcode');
