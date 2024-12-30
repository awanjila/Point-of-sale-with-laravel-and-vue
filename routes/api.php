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


Route::get('/pos/products', [POSController::class, 'getProducts']);
Route::get('/pos/categories', CategoryController::class);
Route::get('/pos/customers', CustomerController::class);
// Route::get('/cart-items', CartController::class);

Route::post('/customers', [CustomerController::class, 'store']);
Route::post('/orders', [OrderController::class, 'createOrder']);
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











