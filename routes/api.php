<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackOffice\POSController;
use App\Http\Controllers\BackOffice\CategoryController;
use App\Http\Controllers\BackOffice\CartController;
use App\Http\Controllers\BackOffice\CustomerController;
use App\Http\Controllers\BackOffice\OrderController;


Route::get('/pos/products', POSController::class);
Route::get('/pos/categories', CategoryController::class);
Route::get('/pos/customers', CustomerController::class);
// Route::get('/cart-items', CartController::class);

Route::post('/customers', [CustomerController::class, 'store']);
Route::post('/orders', [OrderController::class, 'createOrder']);
Route::get('/order/{id}', [OrderController::class, 'getOrderById']);

Route::get('/order/{id}/details', [OrderController::class, 'getOrderDetailsById']);








