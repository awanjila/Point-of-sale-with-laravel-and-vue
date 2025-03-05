<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackOffice\POSController;
use App\Http\Controllers\BackOffice\CategoryController;
use App\Http\Controllers\BackOffice\CartController;
use App\Http\Controllers\BackOffice\CustomerController;
use App\Http\Controllers\BackOffice\OrderController;
use App\Http\Controllers\BackOffice\SettingController;
use App\Http\Controllers\BackOffice\SupplierController;
use App\Http\Controllers\BackOffice\ProductController;
use App\Http\Controllers\BackOffice\PurchaseController;
use App\Http\Controllers\BackOffice\ReportsController;
use App\Http\Controllers\BackOffice\EmployeeController;
use App\Http\Controllers\BackOffice\SaleController;



Route::get('/pos/products', [POSController::class, 'getProducts']);
Route::get('/pos/categories', CategoryController::class);
Route::get('/pos/customers', CustomerController::class);
// Route::get('/cart-items', CartController::class);

Route::post('/customers', [CustomerController::class, 'store']);
Route::post('/orders', [OrderController::class, 'StoreOrder']);
Route::get('/order/{id}', [OrderController::class, 'getOrderById']);

Route::get('/order/{id}/details', [OrderController::class, 'getOrderDetailsById']);

Route::get('/settings', [SettingController::class, 'getSettings']);
Route::post('/settings', [SettingController::class, 'updateSettings']);

// Purchase API Routes
    Route::post('/purchases', [PurchaseController::class, 'StorePurchase']);
    Route::get('/suppliers', [SupplierController::class, 'index']);
    Route::get('/products', [ProductController::class, 'index']);    // Add new route for fetching purchases
    Route::get('/purchases', [PurchaseController::class, 'GetPurchases']);
    Route::patch('/purchases/{id}/status', [PurchaseController::class, 'UpdatePurchaseStatus']);
    // New routes for actions
    Route::get('/purchases/{id}', [PurchaseController::class, 'ShowPurchase']);
    Route::patch('/purchases/{id}/complete', [PurchaseController::class, 'CompletePurchase']);
    Route::delete('/purchases/{id}', [PurchaseController::class, 'DeletePurchase']);

    Route::controller(OrderController::class)->group(function () {
        // Get all orders
        Route::get('/orders', 'GetOrders');
        
        // Get single order
        Route::get('/orders/{id}', 'ShowOrder');
        
        // Complete order
        Route::patch('/orders/{id}/complete', 'CompleteOrder');
        
        // Delete order
        Route::delete('/orders/{id}', 'DeleteOrder');
        
        // Store new order
        Route::post('/orders', 'StoreOrder');
    });

    Route::get('/sales-report', [ReportsController::class, 'index']);
    Route::get('/purchase-report-api', [ReportsController::class, 'purchaseReportAPi']);
    Route::post('/suppliers', [SupplierController::class, 'store']);

    Route::post('/products', [ProductController::class, 'store']);


    Route::get('/categories', App\Http\Controllers\BackOffice\CategoryController::class);

    Route::get('/delivery-persons', [EmployeeController::class, 'getDeliveryPersons']);

    // Update the existing products route to handle search
    Route::get('/products/search', [ProductController::class, 'search']);

    Route::get('/customers/search', [CustomerController::class, 'search']);

// Sales Routes
Route::prefix('sales')->group(function () {
    Route::get('/', [SaleController::class, 'index']);
    Route::post('/', [SaleController::class, 'store']);
    Route::get('/{sale}', [SaleController::class, 'show']);
    Route::patch('/{sale}/status', [SaleController::class, 'updateStatus']);
    Route::delete('/{sale}', [SaleController::class, 'destroy']);
    
    // Document routes
    Route::post('{sale}/documents', [SaleController::class, 'uploadDocuments']);
    Route::delete('documents/{document}', [SaleController::class, 'deleteDocument']);
});












